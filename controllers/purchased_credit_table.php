<?php

$transaction = new transaction;
$all_transactions = $transaction->get_transactions($_SESSION['user_id']);

// echo '<pre>';
// var_dump($all_transactions);
// echo '</pre>';
