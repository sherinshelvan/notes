<?php 
namespace TutorialDetails;
require_once( '../controller.php' );
use Controller\Controller;
class Details extends Controller{
	function __construct(){
		$args = array(	
										"navigation",  
										"active_link" => "tutorial"
									);
		// $this->checkLogin();
		parent::__construct($args);
		$this->table_name        = "../database/tutorial.json";
		$this->category_table    = "../database/category.json";
		$this->page_url          = 'tutorial/details.php';
		$this->return_url        = 'tutorial';
		$this->file_destination  = "assets/uploads/";
		$this->index();
		$this->load_footer($args);
	}
	private function index(){
		$get_data              = $_GET;
		$page_heading          = "Tutorial Details";
		$this->tutorial_result =  json_decode(file_get_contents($this->table_name), true);
		$invalid_attemp 			 = true;
		$this->goback_url      = $this->return_url;
		if(isset($get_data['from']) && $get_data['from'] != '' ){
			$this->goback_url      = $this->base_url.$get_data['from'];
		}
		if(isset($get_data['id']) && $get_data['id'] != '' ){
			if( is_numeric(array_search($get_data['id'], array_column($this->tutorial_result, 'id'))) &&array_search($get_data['id'], array_column($this->tutorial_result, 'id')) >= 0 ){
				$invalid_attemp        = false;
				$position              =  array_search($get_data['id'], array_column($this->tutorial_result, 'id'));
				$this->tutorial_result = $this->tutorial_result[$position];
				$this->category_result =  json_decode(file_get_contents($this->category_table), true);
				$cat_id                = $this->tutorial_result['category'];
				$cat_position          =  array_search($cat_id, array_column($this->category_result, 'id'));
				if(is_numeric($cat_position)){
					$this->category_result = $this->category_result[$cat_position];
				}
				else{
					$this->category_result = array();
				}
				
			}
		}
		if($invalid_attemp){
			header("Location: ". $this->base_url. $this->return_url);
		}		
		include_once('./view/details.php');
	}
	private function list(){
		$page_heading = "Tutorials";
		
		$get_data     = $_GET;
		$result       = json_decode(file_get_contents($this->table_name), true);
		if(isset($get_data['action']) && $get_data['action'] == 'delete' && isset($get_data['id']) && $get_data['id'] != '' ){
			
			if( is_numeric(array_search($get_data['id'], array_column($result, 'id'))) &&array_search($get_data['id'], array_column($result, 'id')) >= 0 ){
				$position =  array_search($get_data['id'], array_column($result, 'id'));
				if(count($result[$position]['files']) > 0){
					$file = $result[$position]['files']['details'][0];
					@unlink("../".$result[$position]['files']['file_path'].$file['name']);
				}
				unset($result[$position]);
				$file           = fopen($this->table_name, "w");
				fwrite($file, json_encode( array_values($result), JSON_PRETTY_PRINT ) );
				fclose($file);
			}
		}
		
		
		include_once('./view/list.php');
	}
	private function add(){
		$page_heading = "Add Tutorial";
		
		$form_data = $_POST;
		if($form_data && isset($form_data['doSave']) && !empty($form_data['doSave']) ){
			$form_data['status'] = (isset($form_data['status']) ? 1 : 0);
			$message = '';
			$this->validate($message, $form_data);
			if($message == ''){		

				$result    = json_decode(file_get_contents($this->table_name), true);
				$files = array();
				if(isset($_FILES["image"]) && $_FILES['image']['name'] != ''){
					$file_tmp    = $_FILES['image']['tmp_name'];
					$file_name   = $_FILES['image']['name'];
					$files       = array(
						"file_path" => $this->file_destination,
						"details"		=> array(
							0 => array(
								"name" => $_FILES['image']['name'],
								"type"	=> $_FILES['image']['type']
							)
						)
					);
					$upload_path = $this->file_destination.$file_name;
					move_uploaded_file($file_tmp, '../'.$upload_path);
				}
				$result[] = array(	
																	"id"       => uniqid(), 
																	"title"    => $form_data['title'], 
																	"category" => $form_data['category'], 
																	"content"  => $form_data['content'], 
																	"files"    => $files,
																	"status"   => $form_data['status']
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
		//(strpos($email, '@') === true)
		$page_heading  = "Edit Tutorial";
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
						$result = json_decode(file_get_contents($this->table_name), true);
						$files  = array();
						if(isset($form_data['pre_file'])){
							$files  = $result[$position]['files'];
						}
						if(
							count($result[$position]['files']) > 0 &&
							(
								!isset($form_data['pre_file']) || 
								(isset($_FILES["image"]) && $_FILES['image']['name'] != '')
							)
						){

							$file = $result[$position]['files']['details'][0];
							@unlink("../".$result[$position]['files']['file_path'].$file['name']);
						}
						if(isset($_FILES["image"]) && $_FILES['image']['name'] != ''){
							$file_tmp    = $_FILES['image']['tmp_name'];
							$file_name   = $_FILES['image']['name'];
							$files       = array(
								"file_path" => $this->file_destination,
								"details"		=> array(
									0 => array(
										"name" => $_FILES['image']['name'],
										"type"	=> $_FILES['image']['type']
									)
								)
							);
							$upload_path = $this->file_destination.$file_name;
							move_uploaded_file($file_tmp, '../'.$upload_path);
						}
						$result[$position]['title']    = $form_data['title'];
						$result[$position]['category'] = $form_data['category'];
						$result[$position]['content']  = $form_data['content'];
						$result[$position]['files']    = $files;
						$result[$position]['status']   = $form_data['status'];
						$file                          = fopen($this->table_name, "w");
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
		if(empty($form_data['title'])){
			$message .= "<p>Title field required!</p>";
		}
		if(empty($form_data['category'])){
			$message .= "<p>Category field required!</p>";
		}
		$localStorage = json_encode(array('type' => 'error', 'message' => $message));
		$_SESSION["message"] = $localStorage;
	}
}
$obj = new Details();
?>




