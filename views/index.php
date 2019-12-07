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

       	//if(empty($this->page) AND !isset($_COOKIE['Auth'])){ // Au cas ou un nom de page est entre dans l'url:

			//$this->page = 'login'; // alors changer le nom de la page par default

		//}

       	if(empty($this->page) AND isset($_COOKIE['Auth'])){ // Au cas ou un nom de page est entre dans l'url:

			//$this->page = 'order_list'; // alors changer le nom de la page par default

		}

		if (!empty($this->page) AND !isset($_COOKIE['Auth']) AND isset($_SESSION['Auth'])) {
			
			$this->page = strtolower(trim(preg_replace('~[^0-9a-z_]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($_GET['page'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));

			//$this->page = 'order_list'; // alors changer le nom de la page par default
       	
       	}
	}

	public function lancement(){

		include_once("controllers/controller_content.inc.php");   
		include_once("views/layout/public_template.tpl");

	}
}

$redirection = new FrontController();
$redirection->lancement();