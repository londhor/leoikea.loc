<?php

use classes\QueryBuilder as QB;
// PAYMENT STATUS  *****************************************

function updatePaymentStatus($payment_data) {
	if (isset($payment_data['order_status'])=='approved' && isset($payment_data['order_id'])) {
		$QB = new QB;
		$QB->updateField(
			//UPDATA
			'bookings',
			//SET
			'paymentstatus',
			// where
			'id',
			// id==
			$payment_data['order_id'],
			// data
			1
		);
	}
}

// ACTIONS *****************************************

function booking($data,$callback=true) {
	$QB = new QB;

	$callback = true;
	$removedBonus=0;

	$cart = json_decode($data['cart'], true);
	$totalCartPrice = getTotalCartPrice($cart);
	$data['payment_total'] = $totalCartPrice;

	// if user need to use bonuses
	if (isset($data['bonus'])) {
		$removedBonus = removeBonuses($data['phone'], $totalCartPrice);
		$data['bonus'] = $removedBonus;
	}

	// Total cart payment
	$priceToPayment = round($totalCartPrice-$removedBonus);

	// add bonus from payment
	if (isset($data['phone'])) { 
		addBonus($data['phone'], $priceToPayment);
	}

	$booking_id = $QB->create('bookings', $data);

	if (isset($data['paymenttype']) && isset($data['paymenttype'])=='card') {
		$payment_url = merchantAction($priceToPayment, $booking_id, $cart);	
	}

	if ($_SERVER['SERVER_NAME']=='ikea.lviv.ua') {
		sendNotification();
	}

	if ($callback) {
		$callbackArr = array();

		if (isset($payment_url)) {
			$callbackArr['payment_url'] = $payment_url;
			JsCallback('booking', $callbackArr);
		} else {
			$callbackArr['data'] = '';
			JsCallback('booking', $callbackArr);
		}
	}

}

// MERCHANT *****************************************

function merchantAction($amount, $booking_id, $cart) {
	if ($amount && $booking_id && $cart):

		\Cloudipsp\Configuration::setMerchantId(MERCHANT_ID);
		\Cloudipsp\Configuration::setSecretKey(MERCHANT_SECRET_KEY);
	
		// FOR TEST
		// \Cloudipsp\Configuration::setMerchantId(1396424);
		// \Cloudipsp\Configuration::setSecretKey('test');
		
		$checkoutData = [
		    'currency' => 'UAH',
		    // 'amount' => $amount*100,
		    'amount' => 10,
    	    'order_id' => $booking_id,
    	    
    	    /// TEST //////////////////////////////
    	    'order_desc' => 'ikea.lviv.ua — оплата покупки',
    	    'default_payment_system' => 'card',
    	    'merchant_data' => $cart,
		];
		$mdata = \Cloudipsp\Checkout::url($checkoutData);
		$url = $mdata->getUrl();
		return $url;
	endif;
	// $mdata->toCheckout();
}

// BONUS & USER *****************************************

function removeBonuses($phone, $totalCartPrice) {
	if ($phone):
		$userBonuses = getBonus($phone);
	
		if ($totalCartPrice>$userBonuses) {
		    $removedBonuses = $userBonuses;
		} else {
		    $removedBonuses = $userBonuses - ($userBonuses-$totalCartPrice);
		}
	
		$newUserBonuses = $userBonuses - $removedBonuses;
	
		$QB = new QB;
		$QB->updateField('clients', 'bonus', 'phone', $phone, $newUserBonuses);
	
		//echo 'bonus ballance after removed:'.getBonus($phone).'//</br>';
		//echo 'removed bonuses:'.getBonus($removedBonuses).'//</br>';
	
		return $removedBonuses;
	else:
		echo "Ошибка";
	endif;
}

function addBonus($phone, $totalCartPrice) {

	$QB = new QB;
	$user = getUserByPhone($phone);

	if (!$user) {
		$QB->create('clients', array('phone'=>$phone));
	}

	$currentBonusBalance = 0;
	$currentBonusBalance = getBonus($phone);
	$newBonusBalance = $currentBonusBalance+(($totalCartPrice/100)*BONUS_PERCENT);

	$QB->updateField('clients', 'bonus', 'phone', $phone, $newBonusBalance);

	//echo 'new bonus ballance:'.$newBonusBalance.'//</br>';

	return $newBonusBalance;
}

function getBonus($phone, $callback=false) {

	if (is_array($phone)) {
		$phone = $phone['phone'];
	}

	$QB = new QB;
	$bonus = $QB->getField('clients', 'bonus', 'phone', $phone);

	if ($callback) {
		if (!$bonus) {
			$bonus = array('bonus'=>false);
		}
		JsCallback('getBonus', $bonus);	
	}

	return $bonus;
}

// USER *****************************************

function getUserByPhone($phone=false) {
	$QB = new QB;
	$user = $QB->getOne('clients','phone',$phone);

	return $user;
}

// JsCallback *****************************************

function JsCallback($callback, $data=true) {
	if ($callback && $data) {
		$callbackArr = array(
			'callback'=> $callback,
			'data'=> $data,
		);

		print_r(json_encode($callbackArr));
	}
}

// CART PRICE *****************************************

function getTotalCartPrice($cart) {

	$totalCartPrice = 0;

	if ($cart) {
		foreach ($cart as $item) {
			$totalCartPrice+=$item['price'] * $item['count'];
		}
	}

	return $totalCartPrice;
}


// PRODUCT OPTIONS *****************************************

function getProductOptions($data) {
	if (isset($data['id'])) {
		$id=$data['id'];
	}
	$pdo = new QB;
	if ($id) {
			
		$table="products";
		$id=$id;

		$sql = "SELECT variations, variations_pl FROM {$table} WHERE id=:id";
		$stm = $pdo->prepare($sql);
		$stm->bindParam(':id', $id);
		$stm->execute();
		$options = $stm->fetchAll(PDO::FETCH_ASSOC);

		if (isset($options[0])) {
			$options = $options[0];
	
			if (isset($options['variations'])) {
				$optionsStr = $options['variations'];
			} else {
				$optionsStr = $options['variations_pl'];
			}

			$optionsStr = filterOptions($optionsStr);
			print_r($optionsStr);		
		}
	}
}

function filterOptions($options=false) {
	if ($options) {
		$options = str_replace('\t','', $options);
		$options = preg_replace("/\s+/", "", $options);
		$options = json_decode($options);
		if ($options) {
			$i=0;
			foreach ($options as $opt) {
				$options[$i]->text = $options[$i]->title;
				$options[$i]->value = $options[$i]->text;
				$i++;
			}
		}

		return json_encode($options);
	}
}

// ANOTHER *****************************************



function sendNotification($data) {

	print_r($data);

	$parseWhat = $data['parse_what'];
	$parseStatus = $data['parse_status'];

	date_default_timezone_set('Europe/Kiev');

    $type='telegram';

    if ($type=='telegram') {

      // OPTIONS //////////////////////////////////////////////////////
      $tg_users = array(
		// '656742796', // ikea
		'363529419', //londhor
      );
      $tg_bot_token = '732599170:AAF3AUe9gakw6klEXQ_Vf-ncdNmhZo6eBlI';
      /////////////////////////////////////////////////////////////////
      $date = date('d.m.Y H:i');

      if ($parseWhat && $parseStatus) {
      	if ($parseStatus=='start') {
      		$statusMessage = 'розпочато';
      	} elseif ($parseStatus=='finish') {
			$statusMessage = 'завершено';
      	}
		$tg_message = "{$date} — Парсинг даних з {$parseWhat} {$statusMessage} ";
      } else {
      	$tg_message = "{$date} - Нове замовлення на сайті!";
      }

      $tg_link = false;
      foreach ($tg_users as $user) {
      	$tg_link = "https://api.telegram.org/bot{$tg_bot_token}/sendMessage?chat_id={$user}&text={$tg_message}";
		file_get_contents($tg_link);
      }
    }
}

function ajaxCanEdit() {
	$ref = $_SERVER['HTTP_REFERER'];
	$haveAccess = array('beta.ikea.lviv.ua','beta.leoikea.loc','ikea.lviv.ua');
	
	foreach ($haveAccess as $site) {
		if (strripos($ref, $site)) {
			return true;
		}
	}

	return false;
	die;
}

function getAndDoAction() {
	if(isset($_POST['action'])) {
		$action = $_POST['action'];
		unset($_POST['action']);

		if (isset($_POST['callback'])) {
			$callback = $_POST['callback'];
		} else {
			$callback = false;
		}

		$data = $_POST;
		$action($data,$callback);
	}
}



/////////////////////////////////////////////////

//$a= Array(
//    [rrn] => 
//    [masked_card] => 516875XXXXXX0575
//    [sender_cell_phone] => 
//    [response_status] => success
//    [sender_account] => 
//    [fee] => 
//    [rectoken_lifetime] => 
//    [reversal_amount] => 0
//    [settlement_amount] => 0
//    [actual_amount] => 10
//    [order_status] => approved
//    [response_description] => 
//    [verification_status] => 
//    [order_time] => 28.07.2019 14:39:37
//    [actual_currency] => UAH
//    [order_id] => 1564313977
//    [parent_order_id] => 
//    [merchant_data] => {"S79253457":{"img":"\/\/ikea.lviv.ua\/images\/products\/froson-duvholmen-poduszka-na-krzes-o-ogrodowa-niebieski__0685059_PE721326_S4.JPG","title"//:"FR\u00d6S\u00d6N\/\n\t\t\t\t\t\tDUVHOLMEN","header":"Poduszka na krzes\u0142o, ogrodowa, niebieski","price":480,"count":"1"},"00300664":{"img":"//\/\/ikea.lviv.ua\/images\/products\/brimnes-szafka-drzwi-czarny__0621549_PE689983_S4.JPG","title":"\u0411\u0420\u0418\u041c\u041d\u042d\u0421","header":"//\u0428\u0430\u0444\u0430 \/ \u0434\u0432\u0435\u0440\u0456, \u0441\u043a\u043b\u043e, \u0447\u043e\u0440\u043d\u0438\u0439","price":4788,"count":"1"}}
//    [tran_type] => purchase
//    [eci] => 5
//    [settlement_date] => 
//    [payment_system] => card
//    [rectoken] => 
//    [approval_code] => 81568B
//    [merchant_id] => 1425859
//    [settlement_currency] => 
//    [payment_id] => 157742573
//    [product_id] => 
//    [currency] => UAH
//    [card_bin] => 516875
//    [response_code] => 
//    [card_type] => MasterCard
//    [amount] => 10
//    [sender_email] => krya7an@gmail.com
//    [signature] => edda0ff50dc5d3849fdede6a78f8ce5ad577024d
//)

////////////////


////////////////////////



//     Array
// (
//     [rrn] => 
//     [masked_card] => 516875XXXXXX0575
//     [sender_cell_phone] => 
//     [response_status] => success
//     [sender_account] => 
//     [fee] => 
//     [rectoken_lifetime] => 
//     [reversal_amount] => 0
//     [settlement_amount] => 0
//     [actual_amount] => 10
//     [order_status] => approved
//     [response_description] => 
//     [verification_status] => 
//     [order_time] => 28.07.2019 14:47:59
//     [actual_currency] => UAH
//     [order_id] => 1564314479
//     [parent_order_id] => 
//     [merchant_data] => {"S79253457":{"img":"\/\/ikea.lviv.ua\/images\/products\/froson-duvholmen-poduszka-na-krzes-o-ogrodowa-niebieski__0685059_PE721326_S4.JPG","title":"FR\u00d6S\u00d6N\/\n\t\t\t\t\t\tDUVHOLMEN","header":"Poduszka na krzes\u0142o, ogrodowa, niebieski","price":480,"count":"1"},"00300664":{"img":"\/\/ikea.lviv.ua\/images\/products\/brimnes-szafka-drzwi-czarny__0621549_PE689983_S4.JPG","title":"\u0411\u0420\u0418\u041c\u041d\u042d\u0421","header":"\u0428\u0430\u0444\u0430 \/ \u0434\u0432\u0435\u0440\u0456, \u0441\u043a\u043b\u043e, \u0447\u043e\u0440\u043d\u0438\u0439","price":4788,"count":"1"}}
//     [tran_type] => purchase
//     [eci] => 5
//     [settlement_date] => 
//     [payment_system] => card
//     [rectoken] => 
//     [approval_code] => 34068B
//     [merchant_id] => 1425859
//     [settlement_currency] => 
//     [payment_id] => 157743677
//     [product_id] => 
//     [currency] => UAH
//     [card_bin] => 516875
//     [response_code] => 
//     [card_type] => MasterCard
//     [amount] => 10
//     [sender_email] => krya7an@gmail.com
//     [signature] => b4c20291721a0c080b35cb5ce60e641a46b6e01b
// )
// -----------Array
// (
//     [payment_status] => 'success'
// )

