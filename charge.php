<?php
require_once('vendor/autoload.php');
require_once('models/transaction.class.php');

$transaction = new transaction;

// secret key
\Stripe\Stripe::setApiKey('sk_test_F39BYV9HBIt5U0G2Un8IzJYw');

// check for form errors
if (isset($_POST['amount']) && $_POST['amount']<100) {
    $host = $_SERVER['HTTP_HOST'];
    header('Location: http://'.$host.'?page=buy_points&low-amount=true');
}

// Sanitize POST Array
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

// check for form errors
if ($_POST['qty'] < $_POST['min-point'] || $_POST['first_name']=="" || $_POST['last_name']=="" || $_POST['email']=="" ) {
    if ($_POST['qty'] < $_POST['min-point']) {
      $low_amount = TRUE;
    } 
    if ($_POST['first_name']=="") {
      $missing_first_name = TRUE;
    } else {
      $missing_first_name = $_POST['first_name'];
    }
    if ($_POST['last_name']=="") {
      $missing_last_name = TRUE;
    } else {
      $missing_last_name = $_POST['last_name'];
    }
    if ($_POST['email']=="") {
      $missing_email = TRUE;
    } else {
        $missing_email = $_POST['email'];
    }

    $host = $_SERVER['HTTP_HOST'];
    header('Location: http://'.$host.'?page=buy_points&low-amount='.$low_amount.'&missing-first-name='.$missing_first_name.'&missing-last-name='.$missing_last_name.'& missing-email='.$missing_email);
}

$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$email = $POST['email'];
$token = $POST['stripeToken'];
$amount = $POST['amount'];
$qty = $POST['qty'];
$user_id = $_POST['user_id'];

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

\Stripe\InvoiceItem::create([
  'amount' => $charge->amount,
  'currency' => $charge->currency,
  'customer' => $charge->customer,
  'description' => $charge->description,
]);

// Invoicing
$invoice = \Stripe\Invoice::create([
  'customer' => $charge->customer,
  'collection_method' => 'send_invoice',
  'days_until_due' => 1,
]);

echo 'POST<br><pre>';
  //print_r($invoice);
echo '</pre>';


// Add Transaction To DB
if (isset($transData['status']) && $transData['status'] == 'succeeded'){
  $stripe_new_transaction = $transaction->stripeNewTransaction($user_id, $transData['id'], $first_name, $last_name, $email, $transData['customer_id'], $transData['product'], $amount, $qty, $transData['currency'], $transData['status'], $invoice['id']);
}

// echo 'stripe_new_transaction : '.$stripe_new_transaction;
echo '<pre>';
//   print_r($_POST);
//echo '</pre>';
//echo 'transData<br><pre>';
//   print_r($transData);
echo '</pre>';

// Redirect to success
$host = $_SERVER['HTTP_HOST'];
header('Location: http://'.$host.'?page=success&tid='.$charge->id.'&product='.$charge->description);

Test git ignore