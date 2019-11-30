<?php
include_once('info.model.php');

class Database {
	private static $mysqli = null;
	
	static function connect() {
		if (isset(self::$mysqli) && self::$mysqli->ping()) {
			//self::$mysqli->close();
			return true;
		}
		self::$mysqli = new mysqli(
			$GLOBALS['DB_URL'].':'.$GLOBALS['DB_PORT'],
			$GLOBALS['DB_USER'],
			$GLOBALS['DB_PASS'],
			$GLOBALS['DB_NAME']);
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
			if (count($params) > 0) {
				$s = str_repeat('s', count($params));
				// $params = array_map('htmlspecialchars', array_map('addslashes', $params));
				$params = array_map('htmlspecialchars', $params);
				$stmt->bind_param($s, ...$params);
			}
			
			$stmt->execute();
			return $stmt->get_result();
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Error connecting to database'); //Should be a message a typical user could understand
			return false;  
		}
	}

	static function execute_multi_queries_with_prepared_statement($query=array(), $params=array()){
		try {
			self::connect();
			$stmt = self::$mysqli->prepare($query);
			if (count($params) > 0) {
				$s = str_repeat('s', count($params));
				// $params = array_map('htmlspecialchars', array_map('addslashes', $params));
				$params = array_map('htmlspecialchars', $params);
				$stmt->bind_param($s, ...$params);
			}
			
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
			return "";
		} else {
			return $result->fetch_assoc();
		}
	}

	static function clearRequest($req){
		$req->closeCursor();
	}
}
?>
