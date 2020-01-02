<?php
$notification = new notification;
$user = new user;
$user_contacts = $user->contacts($_SESSION['user_id']);
if (empty($user_contacts)){
    $user_contacts=[];
}
//echo '<pre>';
//var_dump($user_contacts);
//echo '</pre>';
if (isset($_POST['invite-email'])){
    $notification_invite_email = $notification->invite_email($_SESSION['user_id'], $_POST['invite-email']);
    echo $notification_invite_email;
}
