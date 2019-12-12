<?php
require_once('db_connect.class.php');

/**  
* @desc    
* examples 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  

class transaction extends db_connect{

    public function stripeNewTransaction($user_id, $txn_id, $first_name, $last_name, $email, $customer_id, $product, $amount, $currency_code, $payment_status){

        $pdostatement = $this->query('INSERT INTO tbl_payment(user_id, txn_id, first_name, last_name, email, customer_id, product, amount, currency_code, payment_status, created_at) VALUE('.$user_id.', "'.$txn_id.'", "'.$first_name.'", "'.$last_name.'", "'.$email.'", "'.$customer_id.'", "'.$product.'", "'.$amount.'", "'.$currency_code.'", "'.$payment_status.'", NOW())  ;');

        if (!$pdostatement) {
            $msg = "\nPDO::errorInfo():\n";
            $msg .= print_r($this->errorInfo());
            return $msg;
        }
    }
}