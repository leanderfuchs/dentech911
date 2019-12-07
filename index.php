<?php 
require_once('models/autoload.inc.php');

/**  
* @desc affichage des pages en fonction de leurs contenu  
* examples index.php = accueil 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required require_once('models/autoload.inc.php');
*/  

class FrontController{
	public function __construct(){

		if(isset($_GET['page'])){
			$this->page = strtolower(trim(preg_replace('~[^0-9a-z_]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($_GET['page'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
		}
	}

	public function lancement(){
		include_once("controllers/controller_content.inc.php");   
		include_once("views/layout/public_template.tpl");
	}
}

$redirection = new FrontController();
$redirection->lancement();