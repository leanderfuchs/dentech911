<?php

$user = new user;
$user_contacts = $user->contacts($_SESSION['user_id']);
if (empty($user_contacts)){
    $user_contacts=[];
}
echo '<pre>';
//var_dump($user_contacts);
echo '</pre>';
