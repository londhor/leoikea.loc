<?php
namespace classes;

use PDO as PDO;

class QueryBuilder extends PDO
{
	private $pdo;

	public function __construct()
	{
		$driver = DB_DRIVER;
		$host = DB_HOST;
		$dbname = DB_NAME;
		$user = DB_USER;
		$pass = DB_PASS;

		$this->pdo = new PDO("$driver:host=$host;dbname=$dbname;charset=utf8",$user,$pass);
	}

	//  ******************** CRUD ********************  //

	public function create($table, $data) {
	
		if (isset($data['active'])) {
			unset($data['active']);
		}
	
		$dataKeys = array_keys($data);
		$keys = implode(',', $dataKeys);
		$tags = ':' . implode(', :', $dataKeys);
		
		$sql = "INSERT INTO {$table} ({$keys}) VALUES ({$tags})";
		$stm = $this->pdo->prepare($sql);
		$stm->execute($data);
		return $this->pdo->lastInsertId();
	}

	public function getAll($table) {
		
		$sql = "SELECT * FROM {$table}";
		$stm = $this->pdo->prepare($sql);
		$stm->execute();

		$res = $stm->fetchAll();
		return $res;
	}

	public function getOne($table,$where,$val) {
		
		$sql = "SELECT * FROM {$table} WHERE {$where}=:val";
		$stm = $this->pdo->prepare($sql);
		$stm->bindParam(':val', $val);
		$stm->execute();

		return $stm->fetch(PDO::FETCH_ASSOC);
	}

	public function getField($table='bookings', $field, $where, $val) {
		
		$sql = "SELECT {$field} FROM {$table} WHERE {$where}=:val";
		$stm = $this->pdo->prepare($sql);
		$stm->bindParam(':val', $val);
		$stm->execute();

		$res = $stm->fetch(PDO::FETCH_ASSOC);
		return $res[$field];
	}

	public function update($table='booking',$field,$where,$val) {

		$dataKeys = array_keys($data);
		$keys = implode(',', $dataKeys);
		$tags = ':' . implode(', :', $dataKeys);

		$sql = "UPDATE {$table} SET :field :wr=:val";
		$stm = $this->pdo->prepare($sql);
		$stm->bindParam(':field', $field);
		$stm->bindParam(':wr', $where);
		$stm->bindParam(':val', $val);

		$stm->execute($data);

	}
	// $QB->updateField('clients', 'bonus', 'phone', '+380939104877', 3333);
	public function updateField($table,$field,$wher,$val, $data) {

		$val = "'$val'";

		$sql = "UPDATE {$table} SET {$field}={$data} WHERE ${wher}={$val}";
		$stm = $this->pdo->prepare($sql);

		return $stm->execute();

	}

//  ******************** CRUD - END ********************  //


}