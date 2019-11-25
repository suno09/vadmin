<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class User
{
	public $id_user;
	public $username;
	public $type;
	public $active;
	public $connected;
	public $cookie_value;
	
	public function __construct(){
		$nb_args = func_num_args();
		$args = func_get_args();
		if (method_exists($this,$constructeur='__construct'.$nb_args)) { 
            call_user_func_array(array($this,$constructeur),$args); 
        }
	}

	// no connection
	private function __construct0(){
		$this->connected = 0;
	}

	//connexion avec jeton => jeton n'a pas encore expiré
	private function __construct1($token){
		$this->id_user = DBInfo::$session_id_user;
		$this->username = DBInfo::$session_username;
		$this->type = DBInfo::$session_type;	
		$this->active = DBInfo::$session_active;
		$this->connected = 1; // connexion OK
	}

	//connexion with username & password
	private function __construct2($username, $password){
		$result = Database::execute_query_with_prepared_statement(
			"select * from users where username = lower(?) and password = PASSWORD(?);",
			array($username, md5($password)));
		
		if($result->num_rows === 0) {
			$this->connected = 2; // erreur motpasse ou nom d'utilisateur
		} else if($row = $result->fetch_assoc()) {
			// setcookie(name, value, expire, path, domain, secure, httponly);
			$_SESSION['session_username'] = $this->username;
			$_SESSION['session_expire'] = time() + DBInfo::$session_duration;
			$this->define_user($row);
			$this->define_session();
		}
	}
	
	private function define_user($d){
		$this->id_user = $d['id_user'];
		$this->username = $d['username'];
		$this->type = $d["type"];	
		$this->active = $d['active'];
		$this->connected = 1; // connexion OK
	}

	private function define_session() {
		DBInfo::$session_id_user = $this->id_user;
		DBInfo::$session_username = $this->username;
		DBInfo::$session_type = $this->type;
		DBInfo::$session_active = $this->active;
		DBInfo::$session_expire = $_SESSION['session_expire'];
	}
	
	public function isConnected(){
		return $this->connected;
	}
}
?>
