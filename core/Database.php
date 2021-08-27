<?php 

/**
 * 
 */
class Database
{
	private $__conn;

    use QueryBuilder;

	// Ket noi database
	public function __construct()
	{
		global $db_config;

		$this->__conn = Connection::getInstance($db_config);
	}

	// Them du lieu
	public function insertData($table, $data) {
		if(!empty($data)) {
			$fieldStr = '';
			$valueStr = '';
			foreach ($data as $key => $value) {
				$fieldStr .= $key.',';
				$valueStr .= "'".$value."',";
			}
			$fieldStr = rtrim($fieldStr, ',');
			$valueStr = rtrim($valueStr, ',');

			$sql = "INSERT INTO $table($fieldStr) VALUES ($valueStr)";

			$status = $this->query($sql);

			if($status) {
				return true;
			}
		}
		return false;
	}

	// Sua du lieu
	public function updateData($table, $data, $condition='') {
		if(!empty($data)) {
			$updateStr = '';
			foreach($data as $key => $value) {
				$updateStr .= "$key='$value',";
			}

			$updateStr = rtrim($updateStr, ',');

			if(!empty($condition)) {
				$sql = "UPDATE $table SET $updateStr WHERE $condition";
			} else {
				$sql = "UPDATE $table SET $updateStr"; 
			}

			$status = $this->query($sql);

			if($status) {
				return true;
			}
		}
		return false;
	}

	// Xoa du lieu
	public function deleteData($table, $condition='') {
		if(!empty($condition)) {
			$sql = 'DELETE FROM '.$table.' WHERE '.$condition;
		} else {
			$sql = 'DELETE FROM '.$table;
		}

		$status = $this->query($sql);

		if($status) {
			return true;
		}

		return false;
	}

	// Truy van cau lenh sql
	public function query($sql) {
		try {
			$statement = $this->__conn->prepare($sql);
			$statement->execute();
			return $statement;
		} catch (Exception $e) {
			$mess = $e->getMessage();
			$data['message'] = $mess;
			App::$app->loadError('database', $data);
			die();
		}
	}

	// Tra ve id moi nhat sau khi da chen
	public function lastInsertId() {
		return $this->__conn->lastInsertId();
	}
}