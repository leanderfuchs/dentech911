<?php 

$user = new user;

//------------------------------------ ajout nouveau admin

if (isset($_POST['edit'])) {

	$edit_user = $user->edit($_GET['user_id'], $_POST['type'], $_POST['company'], $_POST['name'], $_POST['address'], $_POST['city'], $_POST['zip'], $_POST['tel'], $_POST['website'], $_POST['comment']);

}
echo $edit_user;
//print_r($_POST);
	      
//------------------------------------ supression membre

if ($_GET['del']==1) {

	$delete_user = $user->delete($_GET['user_id']);

}

$member_list = $user->memberList();

$nb_user = $user->nb_user();