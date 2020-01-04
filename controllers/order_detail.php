<?php 
$Convert_Dates = new Convert_Dates;
$order = new order;
$comment = new comment;
$user = new user;
$tracking = new tracking;

$user_id = $_SESSION['user_id'];

if(isset($_GET['id'])){

	// Get the unique order key from the order ID	
	$unique_order_key = $order->get_order_key_with_id($_GET['id']);
}


//------------------------------------ Error if missing patient or product
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
//------------------------------------ NEW ORDER
//------------------------------------ 

if (isset($_POST['order']) && $_POST['order']=='Commander') {

	//------------------------------------ create a unique key indentifier for this order
	if (!empty($_SESSION['Auth']) AND !empty($_POST['patient'])) {
		$order_patient_name = preg_replace('#[^A-Za-z0-9.]#', '', $_POST['patient']);
		$unique_order_key = $_SESSION['user_id'].$order_patient_name.rand(100,100000);
	}

	//------------------------------------ remove accents 

	function clean_string($str){
	    $accents = Array("/é/", "/è/", "/ê/","/ë/", "/ç/", "/à/", "/â/","/á/","/ä/","/ã/","/å/", "/î/", "/ï/", "/í/", "/ì/", "/ù/", "/ô/", "/ò/", "/ó/", "/ö/");
	    $sans = Array("e", "e", "e", "e", "c", "a", "a","a", "a","a", "a", "i", "i", "i", "i", "u", "o", "o", "o", "o");
	    $str = preg_replace($accents, $sans, $str);  
	    $str = preg_replace('#[^A-Za-z0-9.]#', '', $str);
		$unwanted = array(" ", ".", "-", "_", ",", "/", "+", "#", ";");
		$str = str_replace($unwanted, "-", $str);
	    return $str; 
	}

	// clean entries
	$patient = clean_string($_POST['patient']);
	$teeth = clean_string($_POST['teeth_nbr']);
	$product = clean_string($_POST['product']);
	$shade = clean_string($_POST['vita_body'].$_POST['vita3d_body']);
	$date = date("m").'-'.date("d").'-'.date("Y");

	// Check supplier email. If known, return existing $supplier_user_id. if email is new, create a new user and send new_email notification and return $supplier_user_id
	$supplier_user_id = $user->new_email($_POST['email-order-to']);

	// Ajout dans la base de donnee
	$order_product = $order->product($user_id, $_POST['patient'], $_POST['teeth_nbr'], $_POST['product'], $_POST['vita_body'], $_POST['vita3d_body'], $_POST['implant_name'], $_POST['implant_diam'], $_POST['comment'], $_POST['datepicker'], $unique_order_key, $supplier_user_id, $supplier_user_id);	

	//------------------------------------ Ajouter les fichiers a la BDD
	foreach ($_FILES as $file_nbr => $value) {
		if (($_FILES[$file_nbr]['error'] == 0)){
			$tmp_name = $_FILES[$file_nbr]["tmp_name"];
			$file_name = $_FILES[$file_nbr]['name'];
			$file_clean_name = clean_string($file_name);
			//echo '<br>fileNBR = '.$file_nbr.' <br>TMP_name = '. $tmp_name.' <br>File CLean Name = ' . $file_clean_name . '</br>';
			//------------------------------------ Nouvelle commande.
			$order->add_file($unique_order_key, $file_nbr, $tmp_name, $file_clean_name);
		}
	}
} // END NEW ORDER

// get the unique order Key from the order id
if(!isset($_GET['id'])){
	$unique_order_key = $order->get_last_order_unique_key();
}

// Ajout de fichier(s) a la commande
if (isset($_POST['add_file'])) {

	//------------------------------------ clean names
	function clean_string($str){
	    $accents = Array("/é/", "/è/", "/ê/","/ë/", "/ç/", "/à/", "/â/","/á/","/ä/","/ã/","/å/", "/î/", "/ï/", "/í/", "/ì/", "/ù/", "/ô/", "/ò/", "/ó/", "/ö/");
	    $sans = Array("e", "e", "e", "e", "c", "a", "a","a", "a","a", "a", "i", "i", "i", "i", "u", "o", "o", "o", "o");
	    $str = preg_replace($accents, $sans, $str);  
	    $str = preg_replace('#[^A-Za-z0-9.]#', '', $str);
	    return $str; 
	}

	foreach ($_FILES as $file_nbr => $value) {
		$tmp_name = $_FILES[$file_nbr]["tmp_name"];
		$file_name = $_FILES[$file_nbr]['name'];
		$file_clean_name = clean_string($file_name);

		if (($_FILES[$file_nbr]['error'] == 0)){
			//echo '<br>fileNBR = '.$file_nbr.' <br>TMP_name = '. $tmp_name.' <br>File CLean Name = ' . $file_clean_name . '</br>';
			//------------------------------------ Nouvelle commande.
			$order_add_file = $order->add_file($unique_order_key, $file_nbr, $tmp_name, $file_clean_name);
		}
	}

	//echo $order_add_file;
} //end add_file

// download file and pay one point
if (isset($_GET['file_hash'])){
	if($_SESSION['balance']>0){	
		$order_download_file = $order->download_file($_GET['file_hash'], $_SESSION['user_id']);
		$file_name = $order_download_file['order_file_name'];
		$file_url = $order_download_file['file_url'];
		$file_lock = $order_download_file['unlocked'];
	} else {
		// fetch file status
		$file_lock = $order->file_query($_GET['file_hash'], 'unlocked');
		// fetch file name
		$file_name = $order->file_query($_GET['file_hash'], 'order_file_name');
		// fetch file url
		$file_url = $order->file_query($_GET['file_hash'], 'file_url');

		$insuficient_credit = TRUE;
	}
}


// Liste des fichiers
if (isset($_GET['id'])){
	$order_id = $_GET['id'];
} else {
	$order_id = $order->order_query($unique_order_key, 'id');
}
$order_files = $order->get_files($order_id);
//	echo "<pre>";
//	var_dump($order_files);
//	echo "</pre>";

//------------------------------------ MISE A JOUR AUTOMATIQUE DES STATUS
if (isset($order_id)){
	$order->auto_update_status($order_id, $_SESSION['user_id']);
}


if (isset($_POST['status'])) {
	$order_status = $order->status($_POST['status'], $unique_order_key);
	echo $order_status;
}

$page_access = $user->access($user_id);
// $user_restricted_pages = $user->restricted_pages($user_id, $_GET['id'], $page_access);

//------------------------------------ Get all order details
if(isset($unique_order_key)){
	$order_id = $order->order_query($unique_order_key, 'id');
	$order_client_id = $order->order_query($unique_order_key, 'user_ref_id');
	$order_patient_name = $order->order_query($unique_order_key, 'patient_id');
	$order_status = $order->order_query($unique_order_key, 'status');
	$order_product_name = $order->order_query($unique_order_key, 'product_name');
	$order_teeth_nbr = $order->order_query($unique_order_key, 'teeth_nbr');
	$order_quantity = $order->order_query($unique_order_key, 'quantity');
	$order_vita_body = $order->order_query($unique_order_key, 'vita_body');
	$order_vita3d_body = $order->order_query($unique_order_key, 'vita3d_body');
	$order_localization = $order->order_query($unique_order_key, 'localization');
	$order_paiment_status = $order->order_query($unique_order_key, 'paiment_status');
	$order_implant_name = $order->order_query($unique_order_key, 'implant_name');
	$order_implant_diam = $order->order_query($unique_order_key, 'implant_diam');
	$order_file_path = $order->order_query($unique_order_key, 'file_path');
	$order_ref = $order->order_query($unique_order_key, 'ref');
	$order_lot = $order->order_query($unique_order_key, 'lot');
	$order_tracking = $order->order_query($unique_order_key, 'tracking');
	$order_status = $order->order_query($unique_order_key, 'status');
	$supplier_ref_id = $order->order_query($unique_order_key, 'supplier_ref_id');
	$order_return_date = $Convert_Dates->shortnames(date("l d F Y", strtotime($order->order_query($unique_order_key, 'return_date'))));
	$order_arrival_date = $Convert_Dates->shortnames(date("l d F Y", strtotime($order->order_query($unique_order_key, 'arrival_date'))));
	
	// Affiche les info donnee par le supplier
	$order_track = $tracking->track($order_id);
	// Affiche le premier commentaire
	$comment_first_comment = $comment->first_comment($order_id);
}
//------------------------------------ Get all user details
$client_name = $user->name($order_client_id);
$supplier_email = $user->user_query($supplier_ref_id, 'email');

//echo $order_patient_name.'</br>'.$order_status.'</br>'.$order_teeth_nbr.'</br>'.$order_product_name.'</br>'.$order_teeth_nbr.'</br>'.$order_quantity.'</br>'.$order_vita_body.'</br>'.$order_vita3d_body.'</br>'.$order_return_date.'</br>'.$order_arrival_date.'</br>'.$order_localization.'</br>'.$order_paiment_status.'</br>'.$order_implant_name.'</br>'.$order_implant_diam.'</br>'.$order_file_path;


// Affiche les details de la commande
if (!empty($unique_order_key)){
	$order_details = $order->details_from_unique_order_key($unique_order_key);
} elseif (isset($_GET['id'])){
	$order_details = $order->details($_GET['id']);
	$order_details = explode("|" , $order_details);
	$unique_order_key = $order->get_order_key_with_id($_GET['id']) ;
}

if(isset($_GET['id'])){
	// Affiche les info donnee par le supplier
	$order_track = $tracking->track($_GET['id']);

	// Affiche le premier commentaire
	$comment_first_comment = $comment->first_comment($_GET['id']);

}