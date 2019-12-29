<?php
if (isset($_POST['lostpassword'])) {
	$user= new user;
	$user_newpasswrd = $user->newpasswrd($_POST['email']);
	echo $user_newpasswrd;
}