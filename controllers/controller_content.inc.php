<?php
$ibdd = new db_connect;
$order = new order;
$user = new user;
$Convert_Dates = new Convert_Dates;

// inscrpition de donnés dans la session:
$session = Session::getInstance();
// Exemples: 
// $data = Session::getInstance();
// $data->nickname = 'Someone';
// $data->age = 18;
// Let's display datas
//printf( '<p>My name is %s and I\'m %d years old.</p>' , $data->nickname , $data->age );

if (isset($_POST['inscription'])) {
	$user = new user;
	$user_register = $user->register($_POST['company'],$_POST['name'], $_POST['adresse'], $_POST['zip'], $_POST['city'], $_POST['tel'], $_POST['email'], $_POST['password'], $_SERVER['REMOTE_ADDR']);
	echo $user_register;
}

//------------------------------------ logout
if (isset($_GET['logout']) AND $_GET['logout']=='log_me_out') {
	$user->logout();
}

//$user->logout(); // for debug 


//------------------------------------ Login
if (isset($_POST['login'])) {
	if (!isset($_POST['remember'])) $_POST['remember']='';
	//echo $_POST['remember'];
	$user_login = $user->login($_POST['login-email'],$_POST['login-password'], $_POST['remember']);
	//echo $user_login;
}

if (isset($_SESSION['user_id'])) {
	// at this point, there should be $_SESSION['user_id']
	$user_id = $_SESSION['user_id'];
}

//------------------------------------
//------------------------------------ Cookies
//------------------------------------
if (!isset($_SESSION['Auth']) && isset($_COOKIE['Auth'])){
	$auth = explode('878544', $_COOKIE['Auth']);
	$user_remember_me = $user->remember_me($auth['0'], $auth['1']);
}

//------------------------------------ 
//------------------------------------ affichages des elements de la page
//------------------------------------ 

// recuperation des liens vers les fichiers de la page
if (empty($this->page)) {
	if(isset($_SESSION) ){
		//------------------------------------ if no $_GET['page'] and no session, then go to connexion
		$page_controller_file = 'controllers/login.php';
		$page_view_file = 'views/login.php';
	} else {
		//------------------------------------ if no $_GET['page'] but session open, then go to case list
		$page_controller_file = 'controllers/order_list.php';
		$page_view_file = 'views/order_list.php';
	}
	
} else {
	//------------------------------------ Fetch page name from $_GET['page'] and pass it in the controller and view
	$page_controller_file = 'controllers/' . $this->page . '.php';
	$page_view_file = 'views/' . $this->page . '.php';
}

// affichage du contenu de la page en fonction de son exitence dans les fichiers
function affichage($page_controller_file, $page_view_file){
//------------------------------------ Si page member:
	if (isset($_SESSION['Auth'])) { // For loggedin users
		if(file_exists($page_controller_file) AND file_exists($page_view_file)){
			include($page_controller_file);
			include($page_view_file);
		} else { // If file not fund
			$page_controller_file = 'views/404.php';
			$page_view_file = 'controllers/404.php';
			include($page_controller_file);
			include($page_view_file);
		}
	} elseif(isset($_COOKIE['Auth'])){ // Logged out users with cookie
		$page_controller_file = 'views/order_list.php';
		$page_view_file = 'controllers/order_list.php';
		include($page_controller_file);
		include($page_view_file);
	}else { // if user not logged in
		$page_controller_file = 'views/login.php';
		$page_view_file = 'controllers/login.php';
		include($page_controller_file);
		include($page_view_file);
	}
}

//------------------------------------
//------------------------------------ Show elements of the page from the db_connect Class
//------------------------------------

// Commmon to the whole website
$page_slogan = $ibdd->options_query('slogan');
$point_value = $ibdd->options_query('point_value');
$min_point = $ibdd->options_query('min_point');
$page_menu_header = $ibdd->page_menu('header');
$page_menu_footer = $ibdd->page_menu('footer');

// add point value in the session
if (!empty($point_value)) {
	$session->point_value = $point_value/100;
	$session->min_point = $min_point;
}

// Page specific content
if (isset($_GET['page'])){
	$page_title = $ibdd->page_query($_GET['page'], 'title');
	$page_content = $ibdd->page_query($_GET['page'], 'content');
}

//------------------------------------
//------------------------------------ System debugging
//------------------------------------
$alert = new alert;
	if (isset($_SESSION['Auth'])) {
	$caselist = $alert->changeSentCasesStatus($_SESSION['user_id']);

	if (!empty($caselist)) {
		$displayAlert = $alert->updateStatusToDelivered($caselist);
		echo $displayAlert;
		echo "<pre>";
			print_r($caselist);
		echo "</pre>";
	}
}


$debug = 1;
$show_page_info = 0;
if ($debug==TRUE AND $_SERVER['SERVER_NAME']=="192.168.33.10") {

	print_r($session);

	echo '<h5><b>COOKIE</b></h5>';
	echo "<pre>";
	print_r($_COOKIE);
	echo "</pre>";

	echo '<h5><b>POST</b></h5>';
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	
	echo '<h5><b>GET</b></h5>';
	echo "<pre>";
	print_r($_GET);
	echo "</pre>";
	if(isset($page_access)) echo $page_access;
	
	if (isset($_SESSION['Auth'])) {
		
		echo '<h5><b>SESSION</b></h5>';
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
		echo '<h5><b>FILES</b></h5>';
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";
		
		echo '<br/>$user_id: '.$user_id;
		$session_status = session_status();
		echo '<br/>$session_status: '.$session_status.'</br>';
	}
	
	if($show_page_info == TRUE){
		echo '<p><b>PAGE DETAILS</b></p>';
		echo "<pre>";
		print_r($page_menu_header);
		echo "</pre>";
		echo "<pre>";
		print_r($page_menu_footer);
		echo "</pre>";
		if(isset($_GET['page'])){
			echo 'this is this page detail: page_title : ->'.$page_title.'</br>';
			echo 'this is this page detail: page_content : ->'.$page_content.'</br>';
		}
	}
}