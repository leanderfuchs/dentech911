<?php 
$Convert_Dates = new Convert_Dates;
$order = new order;
$comment = new comment;
$user = new user;

// Liste des fichiers
if (isset($_GET['id'])){
	$order_id = $_GET['id'];
} else {
	$order_id = $order->order_query($unique_order_key, 'id');
}
$order_files = $order->get_files($order_id);


$user_id = $_SESSION['user_id'];

if(isset($_GET['id'])){
	// Affiche les info donnee par le supplier
	$order_track = $order->track($_GET['id']);

	// Mise a jours des informations de tracking donnes par le supplier
	$order_update_status = $order->update_status($_SESSION['Auth'], $_GET['id']);

	// Affiche le premier commentaire
	$comment_first_comment = $comment->first_comment($_GET['id']);

	// Get the unique order key from the order ID	
	$unique_order_key = $order->get_order_key_with_id($_GET['id']);
}



// Liste des fichiers
if (isset($_GET['id'])){
	$order_id = $_GET['id'];
} else {
	$order_id = $order->order_query($unique_order_key, 'id');
}
$order_files = $order->get_files($order_id);
// echo "<pre>";
// var_dump($order_files);
// echo "</pre>";


//------------------------------------ return error if user trys to access pages from other users.

if (!empty($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
}

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
	$order_supplier_id = $order->order_query($unique_order_key, 'supplier_ref_id');
	$order_return_date = $Convert_Dates->shortnames(date("l d F Y", strtotime($order->order_query($unique_order_key, 'return_date'))));
	$order_arrival_date = $Convert_Dates->shortnames(date("l d F Y", strtotime($order->order_query($unique_order_key, 'arrival_date'))));
	//------------------------------------ Get all user details
	$client_name = $user->name($order_client_id);
	$supplier_email = $user->user_query($order_supplier_id, 'email');
}

//echo $order_patient_name.'</br>'.$order_status.'</br>'.$order_teeth_nbr.'</br>'.$order_product_name.'</br>'.$order_teeth_nbr.'</br>'.$order_quantity.'</br>'.$order_vita_body.'</br>'.$order_vita3d_body.'</br>'.$order_return_date.'</br>'.$order_arrival_date.'</br>'.$order_localization.'</br>'.$order_paiment_status.'</br>'.$order_implant_name.'</br>'.$order_implant_diam.'</br>'.$order_file_path;
