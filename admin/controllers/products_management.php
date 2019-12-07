<?php 

$product = new product;

$convertMonthName = new convertMonthName;

if (isset($_POST['add'])) {
	
	$add_product = $product->add($_POST['name'], $_POST['price'], $_POST['processing_time'] );

} 

if ($_GET['del']== 1 ) {

	$delete_product = $product->delete($_GET['id']);

}

if (isset($_POST['edit'])) {

	$edit_product = $product->edit($_GET['product_id'], $_POST['name'], $_POST['price'], $_POST['processing_time']);

}  
