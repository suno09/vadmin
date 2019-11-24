<?php
session_start();
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
		$result = Database::execute_query_with_prepared_statement(
			'select * from tokens where value=? and current_timestamp() < expire_time;', array($token));
		if(($d=$data->fetch())){
				$d = Database::execute_query_with_prepared_statement(
					"select * from users where id_user=?;", array($d['id_user'])
					)->fetch();
				$this->define_compte($d);
				$this->cookie_value = $token;
		} else{
			$this->connected = 0;
		}
	}

	//connexion with username & password
	private function __construct2($username, $password){
		$result = Database::execute_query_with_prepared_statement(
			"select * from users where username = lower(?) and password = PASSWORD(?);",
			array($username, md5($password)));
		
		if($result->num_rows === 0) {
			$this->connected = 2; // erreur motpasse ou nom d'utilisateur
		} else if($row = $result->fetch_assoc()) {
			$this->define_user($d);
			echo 'success cookie '.$d['username'];
			// setcookie(name, value, expire, path, domain, secure, httponly);
			$this->cookie_value = md5($d['username'].time());
			Database::execute_query_with_prepared_statement(
				"update tokens set value=?, expire_time=date_add(current_timestamp(), interval 5 minute) where id_user=?;", 
				array($this->cookie_value, $this->id_user)
			);
			// cookie of 5 min
			$duration_sec = 5 * 60;
			setcookie('token_sundev_vadmin', $this->cookie_value, time() + $duration_sec, null, null, false, true);	
		}

		/*if ($result && $result->num_rows !== 0)
		if(($d = $data->fetch()) != NULL){
			$this->define_user($d);
			echo 'success cookie f '.$this->id_user.'<br />';
			echo 'success cookie f '.$d['username'];
			// setcookie(name, value, expire, path, domain, secure, httponly);
			$this->cookie_value = md5($d['username'].time());
			Database::execute_query_with_prepared_statement(
				"update tokens set value=?, expire_time=date_add(current_timestamp(), interval 5 minute) where id_user=?;", 
				array($this->cookie_value, $this->id_user)
			);
			// cookie of 5 min
			$duration_sec = 5 * 60;
			setcookie('token_sundev_vadmin', $this->cookie_value, time() + $duration_sec, null, null, false, true);
		}
		else{
			echo " failed ".$username.' '.$password;
			$this->connected = 2; // erreur motpasse ou nom d'utilisateur
		}*/
	}
	
	private function define_user($d){
		$this->id_user = $d['id_user'];
		$this->username = $d['username'];
		$this->type = $d["type"];	
		$this->active = $d['active'];
		$this->connected = 1; // connexion OK
	}
	
	public function isConnected(){
		return $this->connected;
	}
}
?>
