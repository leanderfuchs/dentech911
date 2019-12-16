<?php
$user = new user;

$user_email = "";
if(isset($_GET['to-user-id'])){
    $user_email = $user->user_query($_GET['to-user-id'], 'email');
}

if (isset($_POST['successfull-point-transfer']) && $_POST['successfull-point-transfer']== 1){
    // email fund and transfer successfull
    $transfer_point_result = TRUE;
} elseif (isset($_POST['successfull-point-transfer']) && $_POST['successfull-point-transfer']== 0){
    $transfer_point_result = FALSE;
    // email NOT fund and transfer regected
}