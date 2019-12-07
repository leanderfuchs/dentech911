<?php 
$Convert_Dates = new Convert_Dates;
$order = new order;
$user = new user;

// Affiche les details de la commande
$order_details = $order->details($_GET['id']);
if (!empty($order_details)) {
	$order_details = explode("|" , $order_details);
}

//------------------------------------ return error if user trys to access pages from other users.

if (!empty($_SESSION['user_id']) AND empty($_SESSION['opencfao_id'])){
	$user_id = $_SESSION['user_id'];
}

$page_access = $user->access($user_id);

// check if the user is related to this order
$user_restricted_page = $order->restricted_page($_SESSION['user_id'], $_GET['id']);

// get order informations 
$order_unique_key = $order->get_order_key_with_id($_GET['id']);

$order_id = $order->order_query($order_unique_key, 'id');
$order_patient_id = $order->order_query($order_unique_key, 'patient_id');
$order_date =  $order->order_query($order_unique_key, 'arrival_date');
$order_return_date = $order->order_query($order_unique_key, 'return_date');
$order_product_name = $order->order_query($order_unique_key, 'product_name');
$order_teeth_nbr = $order->order_query($order_unique_key, 'teeth_nbr');
$order_qty = $order->order_query($order_unique_key, 'quantity');
$order_vita = $order->order_query($order_unique_key, 'vita_body');
$order_vita3d = $order->order_query($order_unique_key, 'vita3d_body');
$order_lot = $order->order_query($order_unique_key, 'lot');
$order_ref = $order->order_query($order_unique_key, 'ref');