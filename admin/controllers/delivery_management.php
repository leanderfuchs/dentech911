<?php 

$delivery= new delivery;

//------------------------------------ ajout nouveau admin

if (isset($_POST['edit'])) {

	$edit_delivery = $delivery->edit($_GET['delivery_id'], $_POST['track_supplier'], $_POST['track_open']);

}
echo $edit_delivery;
//print_r($_POST);
	     	
$delivery_form = $delivery->form($_GET['delivery_id']);
$delivery_info = explode("|", $delivery_form); 


$delivery_list = $delivery->deliveryList();
