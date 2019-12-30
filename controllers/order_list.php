<?php

$order = new order;
$Convert_Dates = new Convert_Dates;

if (isset($_SESSION['user_id'])) { //uid = user name
	$user_id = $_SESSION['user_id'];	
	$order_caselist = $order->caselist($user_id);
} 

//------------------------------------ Delete product

if (isset($_POST['delete'])) {
	$order_delete = $order->delete($_GET['id']);
} 