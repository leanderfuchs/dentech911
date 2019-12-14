<?
$transaction = new transaction;
$transactions = $transaction->get_transactions($_SESSION['user_id']);
