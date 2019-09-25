<?php 
namespace Logout;
require_once( './controller.php' );
use Controller\Controller;
class Logout extends Controller{
	function __construct(){
		$this->logout();
	}
}
$obj = new Logout();
?>




