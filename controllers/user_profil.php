<?php
$user = new user;

if (isset($_POST['update_profil'])){
	$user->update($_SESSION['user_id'], $_POST['company'], $_POST['address'], $_POST['zip'], $_POST['city'], $_POST['tel'], $_POST['email']);
}

$user_name = $user->user_query($_SESSION['user_id'], 'name');
$user_email = $user->user_query($_SESSION['user_id'], 'email');
$user_company = $user->user_query($_SESSION['user_id'], 'company');
$user_address = $user->user_query($_SESSION['user_id'], 'address');
$user_city = $user->user_query($_SESSION['user_id'], 'city');
$user_tel = $user->user_query($_SESSION['user_id'], 'tel');
$user_zip = $user->user_query($_SESSION['user_id'], 'zip');

