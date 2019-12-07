<?php 

if (isset($_POST['inscription'])) {

	$user = new user;

	$user_register = $user->register($_POST['company'],$_POST['name'], $_POST['adresse'], $_POST['zip'], $_POST['city'], $_POST['tel'], $_POST['email'], $_POST['password'], $_SERVER['REMOTE_ADDR']);

}