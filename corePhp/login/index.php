<?php 
namespace Login;
require_once( '../controller.php' );
use Controller\Controller;
class Index extends Controller{
	function __construct(){
		$args = array(	  
										"active_link" => "login"
									);
		$this->checkLogin('login');
		parent::__construct($args);
		$this->table_name = "../database/users.json";
		$this->page_url  = 'login';
		$this->index();
		$this->load_footer($args);
	}
	private function index(){
		$page_heading    = "Login";	
		$this->post_data = $_POST;
		if(isset($this->post_data) && isset($this->post_data['doLogin']) && $this->post_data['doLogin'] == 'login' ){
			$this->users     = json_decode(file_get_contents($this->table_name), true);
			$username_exist 		= array_search($this->post_data['username'], array_column($this->users, 'username'));
			$password_exist 		= array_search(md5($this->post_data['password']), array_column($this->users, 'password'));
			if(is_numeric($username_exist) && is_numeric($password_exist)
				&& $username_exist ==  $password_exist
			){
				$_SESSION[$this->base_url."username"] = $this->users[$username_exist]['username'];
				$_SESSION[$this->base_url."user_id"] = $this->users[$username_exist]['id'];
				header("Location: ". $this->base_url);
				exit;
			}
		}
		include_once('./view/list.php');
	}
	private function list(){
		$page_heading = "Login";		
		$get_data     = $_GET;
		$result       = json_decode(file_get_contents($this->table_name), true);
		if(isset($get_data['action']) && $get_data['action'] == 'delete' && isset($get_data['id']) && $get_data['id'] != '' ){
			if( array_search($get_data['id'], array_column($result, 'id')) || array_search($get_data['id'], array_column($result, 'id')) == 0 ){
				$position =  array_search($get_data['id'], array_column($result, 'id'));
				unset($result[$position]);
				$file           = fopen($this->table_name, "w");
				fwrite($file, json_encode( array_values($result), JSON_PRETTY_PRINT ) );
				fclose($file);
			}
		}
		
		
		include_once('./view/list.php');
	}
	private function add(){
		$page_heading = "Add Categoties";
		
		$form_data = $_POST;
		if($form_data && isset($form_data['doSave']) && !empty($form_data['doSave']) ){
			$form_data['status'] = (isset($form_data['status']) ? 1 : 0);
			$message = '';
			$this->validate($message, $form_data);
			if($message == ''){				
				$result  = json_decode(file_get_contents($this->table_name), true);
				$result[] = array(	
																	"id"       => uniqid(), 
																	"category" => $form_data['category'], 
																	"status" 	 => $form_data['status']
																);
				$file           = fopen($this->table_name, "w");
				fwrite($file, json_encode( $result, JSON_PRETTY_PRINT ) );
				fclose($file);
				$localStorage = json_encode(array('type' => 'success', 'message' => 'Category added successfully.'));
				$_SESSION["message"] = $localStorage;
				header("Location: ". $this->base_url. $this->page_url);
			}
		}
		include_once('./view/edit.php');
	}
	private function edit(){
		$page_heading  = "Edit Categoties";
		$get_data      = $_GET;
		$result = json_decode(file_get_contents($this->table_name), true);
		if(isset($get_data['action']) && $get_data['action'] == 'edit' && isset($get_data['id']) && $get_data['id'] != '' ){
			if( array_search($get_data['id'], array_column($result, 'id')) || array_search($get_data['id'], array_column($result, 'id')) == 0 ){
				$position  =  array_search($get_data['id'], array_column($result, 'id'));
				$form_data = $result[$position];
				if(isset($_POST['doSave']) && !empty($_POST['doSave']) ){
					$form_data           = $_POST;
					$form_data['status'] = (isset($form_data['status']) ? 1 : 0);
					$message             = '';
					$this->validate($message, $form_data);
					if($message == ''){				
						$result  = json_decode(file_get_contents($this->table_name), true);
						$result[$position]['category'] = $form_data['category'];
						$result[$position]['status']   = $form_data['status'];
						$file           = fopen($this->table_name, "w");
						fwrite($file, json_encode( $result, JSON_PRETTY_PRINT ) );
						fclose($file);
						$localStorage = json_encode(array('type' => 'success', 'message' => 'Category updated successfully.'));
						$_SESSION["message"] = $localStorage;
						header("Location: ". $this->base_url. $this->page_url);
					}
				}
			}			
		}
		include_once('./view/edit.php');
	}
	private function validate(&$message, $form_data){
		if(empty($form_data['category'])){
			$message = "<p>Category field required!</p>";
		}
		$localStorage = json_encode(array('type' => 'error', 'message' => $message));
		$_SESSION["message"] = $localStorage;
	}
}
$obj = new Index();
?>




