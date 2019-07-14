<?php

use classes\QueryBuilder as QB;



        // bonusToEat: function() {
        //     if (this.totalCartPrice()>this.bonus) {
        //         return this.bonus;
        //     } else {
        //         return this.bonus - (this.bonus-this.totalCartPrice());
        //     }
        // },

        // totalCartPriceToPayment: function() {
        //     if (this.useBonus) {
        //         return this.totalCartPrice() - this.bonusToEat();
        //     } else {
        //         return this.totalCartPrice();
        //     }
        // },




// ACTIONS *****************************************

function booking($data) {

	$QB = new QB;
	// $QB->create('bookings', $data);

	$cart = json_decode($data['cart']);
	$totalCartPrice = getTotalCartPrice($cart);

	if (isset($data['bonus'])) { // if user need to use bonuses
		removeBonuses($data['phone'], $totalCartPrice);
	}

	if (isset($data['phone'])) {
		addBonus($data['phone'], $totalCartPrice); // !==========начислять бонусы только на сумма корзины-бонусы !==========
	}

	if ($_SERVER['SERVER_NAME']=='ikea.lviv.ua') {
		sendNotification();
	}

}

// BONUS & USER *****************************************

function removeBonuses($phone, $totalCartPrice) {
	$userBonuses = getBonus($phone);

	if ($totalCartPrice>$userBonuses) {
	    $removedBonuses = $userBonuses;
	} else {
	    $removedBonuses = $userBonuses - ($userBonuses-$totalCartPrice);
	}

	$newUserBonuses = $userBonuses - $removedBonuses;

	$QB = new QB;
	$QB->updateField('clients', 'bonus', 'phone', $phone, $newUserBonuses);

	echo 'bonus ballance after removed:'.getBonus($phone).'<br>';
	return getBonus($phone);
}

function addBonus($phone, $totalCartPrice) {

	$currentBonusBalance = getBonus($phone);
	$newBonusBalance = $currentBonusBalance+(($totalCartPrice/100)*BONUS_PERCENT);

	$QB = new QB;
	$QB->updateField('clients', 'bonus', 'phone', $phone, $newBonusBalance);

	echo 'new bonus ballance:'.$newBonusBalance.'<br>';

	return $newBonusBalance;
}

function getBonus($phone) {

	if (is_array($phone)) {
		$phone = $phone['phone'];
	}

	$QB = new QB;
	$bonus = $QB->getField('clients', 'bonus', 'phone', $phone);

	return $bonus;
}

// CART PRICE *****************************************

function getTotalCartPrice($cart) {

	$totalCartPrice = 0;

	if ($cart) {
		foreach ($cart as $item) {
			$totalCartPrice+=$item->price * $item->count;
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



function sendNotification() {

	date_default_timezone_set('Europe/Kiev');

    $type='telegram';

    if ($type=='telegram') {

      // OPTIONS //////////////////////////////////////////////////////
      $tg_users = array(
		'656742796', // ikea
		'363529419', //londhor
      );
      $tg_bot_token = '732599170:AAF3AUe9gakw6klEXQ_Vf-ncdNmhZo6eBlI';
      /////////////////////////////////////////////////////////////////
      $date = date('d.m.Y H:i');
      $tg_message = "$date - Нове замовлення на сайті!";
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
		$data = $_POST;
		$action($data);
	}
}