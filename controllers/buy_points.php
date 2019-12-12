<?php
$user = new user;

if (isset($_POST['point-input']) && $_POST['point-input']>0){
    $user_credit = $user->add_credit($_SESSION['user_id'], $_POST['point-input']);
    echo $user_credit;
}
