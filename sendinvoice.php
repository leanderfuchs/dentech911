<?php
require_once('vendor/autoload.php');

// secret key
\Stripe\Stripe::setApiKey('sk_test_F39BYV9HBIt5U0G2Un8IzJYw');

// get the invoice number from the url
$invoice_nbr = $_GET['inv-nbr'];

// retrive the invoice from stripe
$invoice = \Stripe\Invoice::retrieve($invoice_nbr);

// send invoice by email
$invoice->sendInvoice();
?>
 <script>
  window.onload = function () {
     open(location, '_self').close();
   };
</script>