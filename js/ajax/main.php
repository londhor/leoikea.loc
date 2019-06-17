<?php


if ($_POST) {

define('DB_DRIVER','mysql');
define('DB_HOST','localhost');
define('DB_NAME','leoikea');
define('DB_USER','user');
define('DB_PASS','pass');

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





















if(isset($_POST['action'])) {
	$action = $_POST['action'];
	unset($_POST['action']);
	$data = $_POST;
	$action($data);
}














}// if-post