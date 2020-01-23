<?php
$ibdd = new db_connect;
$order = new order;
$user = new user;
$Convert_Dates = new Convert_Dates;
$tracking = new tracking;


// inscrpition de donnés dans la session:
$session = Session::getInstance();
if(isset($_SESSION['user_id'])){
	$user_balance = $user->check_balance($_SESSION['user_id']);
}
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

//------------------------------------ Facebook ads
if (isset($_GET['utm_source'])) {
	$source = $_GET['utm_source'];
	echo $user->ads_source($source);
	//echo "facebook ads";
}

//$user->logout(); // for debug 
//unset( $_SESSION );
//session_destroy();

//------------------------------------ Login
if (isset($_POST['login'])) {
	if (!isset($_POST['remember'])) $_POST['remember']='';
	//echo $_POST['remember'];
	$user_login = $user->login($_POST['login-email'],$_POST['login-password'], $_POST['remember']);
	if (!empty($user_login)) {
		echo '<div class="alert alert-danger mt-5">'.$user_login.'</div>';
	}
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
	if( $user_remember_me == TRUE) {
		echo '<div class="alert alert-success mt-5">Vous avez été connecté automatiquement via le cookie sauvegardé dans votre navigateur</div>';
	}
}


//------------------------------------ 
//------------------------------------ Check send new order form
//------------------------------------ 

if (isset($_POST['order']) && $_POST['order'] == "Commander") {
	$missing_patient='';
	$missing_product='';

	if (empty($_POST['patient'])) {
		header('location:?page=order&missing_patient=missingpatient');
	}

	if (empty($_POST['product'])) {
		header('location:?page=order&missing_product=missingproduct');
	}

	if (empty($_POST['email-order-to'])) {
		header('location:?page=order&missing_email=missingemail');
	}
}


//------------------------------------ 
//------------------------------------ Send Points beetween users
//------------------------------------ 

if(isset($_POST['points']) && isset($_POST['to-email'])){
    // check if user has enough points first
    if ($_POST['points'] > $_SESSION['balance']){
        $not_enough_funds = TRUE;
    } else {
        $user_id= $_SESSION['user_id'];
        $points = $_POST['points'];
        $email = $_POST['to-email'];
		$user_send_points = $user->send_points($user_id, $points, $email);
		$_POST['successfull-point-transfer'] = $user_send_points;
    }
}

// Ajout de fichier(s) a la commande
if (isset($_POST['add_file'])) {
	foreach ($_FILES as $file_nbr => $value) {
		// Use
		if ($_FILES[$file_nbr]['error'] === UPLOAD_ERR_OK) {
			//uploading successfully done
		} else {
			echo new UploadException($_FILES[$file_nbr]['error']);
		}
	}
} //end add_file

//------------------------------------ update status form

if (isset($_POST['lot']) && isset($_POST['ref']) && isset($_POST['tracking'])) {
	$order_update_ref = $order->update_order($_GET['id'], 'ref' ,$_POST['ref']);
	$order_update_lot = $order->update_order($_GET['id'], 'lot' ,$_POST['lot']);
	$order_update_tracking = $order->update_order($_GET['id'], 'tracking' ,$_POST['tracking']);
}


//------------------------------------ update status with QR Code

if (isset($_GET['qr']) && $_GET['qr'] == TRUE) {
	$tracking_qr_update_status = $tracking->qr_update_status($_GET['id']);
}

//------------------------------------ 
//------------------------------------ affichages des elements de la page
//------------------------------------ 

// recuperation des liens vers les fichiers de la page
if (empty($this->page)) {
	if(isset($_SESSION['Auth'])) {
		//------------------------------------ if no $_GET['page'] and no session, then go to connexion
		$page_controller_file = 'controllers/login.php';
		$page_view_file = 'views/login.php';
		$_GET['page'] = 'login';
		
	} else {
		//------------------------------------ if no $_GET['page'] but session open, then go to case list
		$page_controller_file = 'controllers/order.php';
		$page_view_file = 'views/order.php';
		$_GET['page'] = 'order';
	}
	
} else {
	//------------------------------------ Fetch page name from $_GET['page'] and pass it in the controller and view
	$page_controller_file = 'controllers/' . $this->page . '.php';
	$page_view_file = 'views/' . $this->page . '.php';
}

// affichage du contenu de la page en fonction de son exitence dans les fichiers
function affichage($page_controller_file, $page_view_file, $url){
//------------------------------------ Si page member:
	if (isset($_SESSION['Auth'])) { // For loggedin users
		if(!file_exists($page_controller_file) AND !file_exists($page_view_file)){
			$page_view_file = 'controllers/404.php';
			$page_controller_file = 'views/404.php';
		}
	} elseif ($url == 'lost_password'){
		$page_view_file = 'controllers/lost_password.php';
		$page_controller_file = 'views/lost_password.php';
	} else { // if user not logged in
		$page_view_file = 'controllers/login.php';
		$page_controller_file = 'views/login.php';
	}
	include($page_controller_file);
	include($page_view_file);	
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
$site_alert = $ibdd->options_query('site_alert');

// add point value in the session
$session->point_value = $point_value/100;
$session->min_point = $min_point;

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