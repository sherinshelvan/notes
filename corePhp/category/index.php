<?php 
namespace Categoties;
require_once( '../controller.php' );
use Controller\Controller;
class Index extends Controller{
	function __construct(){
		$args = array(	
										"navigation",  
										"active_link" => "category"
									);
		$this->checkLogin();
		parent::__construct($args);
		$this->table_name = "../database/category.json";
		$this->page_url  = 'category';
		$this->index();
		$this->load_footer($args);
	}
	private function index(){
		$get_data = $_GET;
		if(isset($get_data['action']) && $get_data['action'] == 'add'){
			$this->add();
		}
		else if(isset($get_data['action']) && $get_data['action'] == 'edit'){
			$this->edit();
		}
		else{
			$this->list();
		}
	}
	private function list(){
		$page_heading = "Categoties";
		
		$get_data     = $_GET;
		$result       = json_decode(file_get_contents($this->table_name), true);
		if(isset($get_data['action']) && $get_data['action'] == 'delete' && isset($get_data['id']) && $get_data['id'] != '' ){
			if( is_numeric(array_search($get_data['id'], array_column($result, 'id'))) &&array_search($get_data['id'], array_column($result, 'id')) >= 0 ){
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
			if( is_numeric(array_search($get_data['id'], array_column($result, 'id'))) &&array_search($get_data['id'], array_column($result, 'id')) >= 0 ){
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




