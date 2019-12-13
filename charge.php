<?php


require_once('vendor/autoload.php');
require_once('models/transactions.class.php');
$transaction = new transaction;

// secret key
\Stripe\Stripe::setApiKey('sk_test_F39BYV9HBIt5U0G2Un8IzJYw');

// check for form errors
if (isset($_POST['amount']) && $_POST['amount']<100) {
    $host = $_SERVER['HTTP_HOST'];
    header('Location: http://'.$host.'?page=buy_points&low-amount=true');
}

// check for form errors
if (isset($_POST)) {
    if ($_POST['amount']<100) $low_amount = TRUE;
    if (empty($_POST['first_name'])) $missing_first_name = TRUE;
    if (empty($_POST['last_name'])) $missing_last_name = TRUE;
    if (empty($_POST['email'])) $missing_email = TRUE;

    $host = $_SERVER['HTTP_HOST'];
    header('Location: http://'.$host.'?page=buy_points&low-amount='.$low_amount.'&missing-first-name='.$missing_first_name.'&missing-last-name='.$missing_last_name.'& missing-email='.$missing_email);
}


// Sanitize POST Array
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$email = $POST['email'];
$token = $POST['stripeToken'];
$amount = $POST['amount'];

// Create Customer In Stripe
$customer = \Stripe\Customer::create(array(
  "email" => $email,
  "source" => $token
));

// Charge Customer
$charge = \Stripe\Charge::create(array(
  "amount" => $amount,
  "currency" => "eur",
  "description" => "Point de téléchargement",
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

// Add Transaction To DB
if (isset($transData['status']) && $transData['status'] == 'succeeded'){
  $stripe_new_transaction = $transaction->stripeNewTransaction($_POST['user_id'], $transData['id'], $transData['first_name'], $transData['last_name'], $transData['email'], $transData['customer_id'], $transData['product'], $transData['amount'], $transData['currency'], $transData['status']);
}

echo $stripe_new_transaction;
print_r($transData);

// Redirect to success
//header('Location: ../views/success.php?tid='.$charge->id.'&product='.$charge->description);