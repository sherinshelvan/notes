<?php 
namespace Home;
require_once( '../controller.php' );
use Controller\Controller;
class Home extends Controller{
	function __construct(){
		$args = array(	
										"navigation",  
										"active_link" => "home"
									);
		// $this->checkLogin();
		parent::__construct($args);
		$this->table_name        = "../database/tutorial.json";
		$this->category_table    = "../database/category.json";
		$this->page_url          = 'home';
		$this->file_destination  = "assets/uploads/";
		$this->index();
		$this->load_footer($args);
	}
	private function index(){
		$page_heading = "Home";
		$this->category_result =  json_decode(file_get_contents($this->category_table), true);
		$this->category_result = array_filter($this->category_result, function ($var) {
						    return ($var['status'] == '1');
						});
		$this->tutorial_result =  json_decode(file_get_contents($this->table_name), true);
		$this->tutorial_result = array_filter($this->tutorial_result, function ($var) {
						    return ($var['status'] == '1');
						});
		include_once('./view/list.php');

	}
	public function getActiveResult($array){
		print_r($array['status']);
		return;
	}
}
$obj = new Home();
?>




