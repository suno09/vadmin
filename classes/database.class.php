<?php
class Database{
	private static $mysqli = null;
	
	static function connect() {
		if (isset(self::$mysqli) && self::$mysqli->ping()) {
			self::$mysqli->close();
		}
		self::$mysqli = new mysqli("localhost:3307", "root", "", "vadmin");
		/* check connection */
		if (self::$mysqli->connect_error) {
			echo "Connect failed: " . self::$mysqli->connect_error . "\n";
			return false;
		}

		return true;
	}

	static function execute_query_with_prepared_statement($query, $params=array()){
		try {
			self::connect();
			$stmt = self::$mysqli->prepare($query);
			$s = str_repeat('s', count($params));
			$stmt->bind_param($s, ...$params);
			$stmt->execute();
			return $stmt->get_result();
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Error connecting to database'); //Should be a message a typical user could understand
			return false;  
		}
	}

	static function execute_query_with_prepared_statement_and_first_row($query, $params=array()){
		$result = execute_query_with_prepared_statement($query, $params);
		if($result->num_rows === 0) {
			return false;
		} else {
			return $result->fetch_assoc();
		}
	}

	static function clearRequest($req){
		$req->closeCursor();
	}
}
?>
