<?php

$tracking = new tracking;

//------------------------------------ update status
$tracking_open_received_status = '';
if (isset($_GET['open']) AND $_GET['open']=="received") {
	$tracking_open_received_status = $tracking->open_received_status($_GET['id']);
}
echo $tracking_open_received_status;

//------------------------------------ display list

$tracking_qrlist = $tracking->qrlist();

/*echo '<pre>';
print_r($_POST) ;
echo '</pre>';*/














