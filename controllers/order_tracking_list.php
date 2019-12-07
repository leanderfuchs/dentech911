<?php

$tracking = new tracking;
$user = new user;
$Convert_Dates = new convert_dates;
//------------------------------------ edit product

if (isset($_POST)) {
	// echo '<pre>';
	// 	var_dump($_POST);
	// echo '</pre>';
	$tracking_edit = $tracking->edit($_POST);
}


//------------------------------------  Case list
$tracking_caselist = $tracking->caselist($_SESSION['user_id']);
// echo '<pre>';
// 	var_dump($tracking_caselist);
// echo '</pre>';