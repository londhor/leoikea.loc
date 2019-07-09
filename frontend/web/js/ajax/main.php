<?php


if ($_POST) {

define('DB_DRIVER','mysql');
define('DB_HOST','localhost');
define('DB_NAME','k49223_crm');
define('DB_USER','k49223_crm_user');
define('DB_PASS','Uk{iGi!i_60c');

$driver = DB_DRIVER;
$host = DB_HOST;
$dbname = DB_NAME;
$user = DB_USER;
$pass = DB_PASS;

$pdo = new PDO("$driver:host=$host;dbname=$dbname;charset=utf8",$user,$pass);

function booking($data) {

	global $pdo;

	if (isset($data['active'])) {
		unset($data['active']);
	}

	$dataKeys = array_keys($data);
	$keys = implode(',', $dataKeys);
	$tags = ':' . implode(', :', $dataKeys);
	
	$table='bookings';
	
	$sql = "INSERT INTO {$table} ({$keys}) VALUES ({$tags})";
	$stm = $pdo->prepare($sql);
	$stm->execute($data);

	sendNotification();

}


function getProductOptions($data) {
	if (isset($data['id'])) {
		$id=$data['id'];
	}
	global $pdo;
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



















if(isset($_POST['action'])) {
	$action = $_POST['action'];
	unset($_POST['action']);
	$data = $_POST;
	$action($data);
}














}// if-post