<?php 
namespace Index;
require_once( './controller.php' );
use Controller\Controller;
class Index extends Controller{
	function __construct(){
		$this->checkLogin('router');
	}
}
$obj = new Index();
?>




