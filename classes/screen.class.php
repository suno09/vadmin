<?php
class Screen
{
	private $user;
	public $doc;
	
	public function __construct($user){
		$this->user = $user;
	}
	
	public function __tostring(){
		if($this->user->connected == 0){
			return (string)include_once('./pages/login.html');
		}
		else if($this->user->connected == 2){
			return (string) include_once("./pages/error.html");
		}
		else{
			if(isset($_GET['message'])){
				$this->doc = new message($this->user);
				return (string)include_once("./pages/message.php");
			}
			else return (string) include_once("./pages/home.php");
		}
	}
	
	public function getUser(){
		return $this->user;
	}
}
?>