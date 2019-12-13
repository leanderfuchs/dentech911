<?php
$user = new user;

if (isset($_POST['point-input']) && $_POST['point-input']>0){
    $user_credit = $user->add_credit($_SESSION['user_id'], $_POST['point-input']);
    echo $user_credit;
}

$point_error_message = '';
$missing_first_name = '';
$missing_last_name = '';
$missing_email = '';

// ERROR not enough points
if (isset($_GET['low-amount']) && $_GET['low-amount']==1){
    $point_error_message = 'Le nombre de points doit être supérieur à '.$_SESSION['min_point'];
}

// ERROR missing firstname
if (isset($_GET['missing-first-name']) && $_GET['missing-first-name']==1){
    $missing_first_name = 'Vous devez entrer votre nom';
}

// ERROR missing lastname
if (isset($_GET['missing-last-name']) && $_GET['missing-last-name']==1){
    $missing_last_name = 'Vous devez entrer votre prenom';
}

// ERROR missing email
if (isset($_GET['missing-email']) && $_GET['missing-email']==1){
    $missing_email = 'Vous devez entrer votre email';
}