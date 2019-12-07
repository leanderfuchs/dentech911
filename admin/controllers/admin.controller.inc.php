<?php
session_start();
$ibdd = new db_admin;
$user = new user;

$website_base_url = $_SERVER['SERVER_NAME'];

if ($_SESSION) {
	if ($_SESSION['loggedin']==TRUE AND $_SESSION['user_type']=="admin") {$loggedin=TRUE;}
}


// affichages des elements de la page
if (isset($loggedin)){
	$page_menu = $ibdd->menu_admin($loggedin);
}

// recuperation des liens vers les fichiers de la page
if (empty($this->page)) {

	//------------------------------------ page par default si aucune page n'est selectione
	$page_controller_file = 'controllers/orders_management.php';
	$page_view_file = 'views/orders_management.php';

} else {

	//------------------------------------ page dynamique
	$page_controller_file = 'controllers/' . $this->page . '.php';
	$page_view_file = 'views/' . $this->page . '.php';
}

// affichage du contenu de la page en fonction de son exitence sois dans les fichiers, sois dans la bdd
function affichage($page_controller_file, $page_view_file){

	if($_SESSION){
		if($_SESSION['loggedin']==TRUE AND $_SESSION['user_type']=="admin") {
			include($page_controller_file);
			include($page_view_file);
		}
	} else {
		$page_controller_file = 'controllers/connexion_admin.php';
		$page_view_file = 'views/connexion_admin.php';
		include($page_controller_file);
		include($page_view_file);
	}
}

//------------------------------------ login

if (isset($_POST['login'])) {

	$user_login = $user->login($_POST['password']);

}

if (isset($user_login)) {
	echo $user_login;
}



//------------------------------------ logout


if (isset($_GET['logout'])) {

	$user->logout();

}

//------------------------------------ delete order

if (isset($_GET['delete_order']) AND $_GET['delete_order']==1) {
	$order = new order;
	$order->delete($_GET['product_id']);
} 





