<?php
require_once('../vendor/autoload.php');
require_once('../models/transactions.class.php');
$transaction = new transaction;

// secret key
\Stripe\Stripe::setApiKey('sk_test_F39BYV9HBIt5U0G2Un8IzJYw');

// Sanitize POST Array
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$email = $POST['email'];
$token = $POST['stripeToken'];

// Create Customer In Stripe
$customer = \Stripe\Customer::create(array(
  "email" => $email,
  "source" => $token
));

// Charge Customer
$charge = \Stripe\Charge::create(array(
  "amount" => 5000,
  "currency" => "usd",
  "description" => "Intro To React Course",
  "customer" => $customer->id
));

// Transaction Data
$transData = [
  'id' => $charge->customer,
  'first_name' => $first_name,
  'last_name' => $last_name,
  'email' => $email,
  'id' => $charge->id,
  'customer_id' => $charge->customer,
  'product' => $charge->description,
  'amount' => $charge->amount,
  'currency' => $charge->currency,
  'status' => $charge->status,
];

// Redirect to success
//header('Location: ../views/success.php?tid='.$charge->id.'&product='.$charge->description);
// echo '<pre>';
// print_r($transData);
// echo $_POST['user_id'];
// echo '</pre>';

// Add Transaction To DB
if (isset($transData['status']) && $transData['status'] == 'succeeded'){
  $stripe_new_transaction = $transaction->stripeNewTransaction($_POST['user_id'], $transData['id'], $transData['first_name'], $transData['last_name'], $transData['email'], $transData['customer_id'], $transData['product'], $transData['amount'], $transData['currency'], $transData['status']);

  echo $stripe_new_transaction;
}