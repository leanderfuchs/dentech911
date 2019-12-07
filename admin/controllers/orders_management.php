<?php 

$order = new order;
$suppliers = new suppliers;

$product= new product;
$product_listing = $product->listing();
$order_details = '';
$supplier_details = '';

if (isset($_GET['edit_order']) AND $_GET['edit_order']==1) {
	$order_details = $order->details($_GET['product_id']);
	$supplier_details = $suppliers->details($_GET['product_id']);
} 


if (isset($_POST['edit'])) {
	$order_edit = $order->edit($_GET['product_id'], $_POST['patient_id'], $_POST['status'], $_POST['paiment_status'], $_POST['teeth_nbr'], $_POST['product_name'], $_POST['quantity'], $_POST['vita'], $_POST['vita3d'],$_POST['supplier']);
	echo $order_edit;
} 


if (isset($_GET['id_commande'])) {

	$order_details = $order->details($_GET['id_commande']);

} 

$order_view = $order->view();

//------------------------------------ leave at the end of the list to keep the option value correct.

if (isset($_GET['edit_order']) AND $_GET['edit_order']==1) {
	$supplier_list = $suppliers->name_supplier_list($_GET['product_id']);
}







