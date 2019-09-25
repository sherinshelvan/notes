<?php 
namespace Controller;
session_start();
class Controller{
	public $site_name, $logged_user;
	public $message = array();
	public $base_url = 'http://192.168.1.126/projects/kuttaru/corePhp/';
	function __construct($args = array()){
		$this->site_name = 'Project Management';
		$this->logged_user = ($_SESSION[$this->base_url."username"]?:'');
		$this->loadIncludes($args);
		

	}
	private function loadIncludes($args){
		include_once('includes/header.php');
		if(in_array('navigation', $args)){
			if($_SESSION[$this->base_url."username"] != '' && 
				$_SESSION[$this->base_url."user_id"]  != ''
			){
				include_once('includes/admin_navigation.php');
			}
			else{
				include_once('includes/navigation.php');
			}
			
		}
		
	}
	public function logout(){
		$_SESSION[$this->base_url."username"] = '';
		$_SESSION[$this->base_url."user_id"]  = '';
		header("Location: ". $this->base_url);
	}
	public function checkLogin($type = ''){ 
		if( isset($_SESSION[$this->base_url."username"]) && $_SESSION[$this->base_url."username"] != '' && isset($_SESSION[$this->base_url."user_id"]) && $_SESSION[$this->base_url."user_id"] != '' && ($type == 'login' || $type == 'router') ){
			header("Location: ". $this->base_url."home");
			exit;
		}
		else if( 
			(
				!isset($_SESSION[$this->base_url."username"]) || $_SESSION[$this->base_url."username"] == '' || !isset($_SESSION[$this->base_url."user_id"]) || $_SESSION[$this->base_url."user_id"] == '' 
			) 
			&& $type != 'login'
		){
			$_SESSION[$this->base_url."username"] = '';
			$_SESSION[$this->base_url."user_id"]  = '';
			if($type == 'router'){
				header("Location: ". $this->base_url."home");
				exit;
			}
			header("Location: ". $this->base_url."login");
			exit;
		}
	}
	public function load_footer($args){
		if(isset($_SESSION["message"]) && $_SESSION["message"] != ''){
			echo '<script>localStorage.setItem("messages", JSON.stringify('.$_SESSION["message"].') );</script>';
				unset($_SESSION["message"]);

		}
		include_once('includes/footer.php');
	}
	private function test(){
		echo 'controller<br/>';
	}
}
?>