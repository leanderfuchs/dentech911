<?php

$tracking = new tracking;
$Convert_Dates = new Convert_Dates;
$ex3 = new QRGenerator;

//------------------------------------ update status

if (isset($_GET['open']) AND $_GET['open']=="received") {
	$tracking_open_received_status = $tracking->open_received_status($_GET['id']);
	echo $tracking_open_received_status;
}

//------------------------------------ display list

$tracking_qrlist = $tracking->caselist($_SESSION['user_id']);

/*echo '<pre>';
print_r($_POST) ;
echo '</pre>';*/