<?php
require_once('db_connect.class.php');
require_once('Session.class.php');
/**  
* @desc    
* examples 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  

class transaction extends db_connect{

    public function stripeNewTransaction($user_id, $txn_id, $first_name, $last_name, $email, $customer_id, $product, $amount, $qty, $currency_code, $payment_status){

        $pdostatement = $this->query('INSERT INTO tbl_payment(user_id, txn_id, first_name, last_name, email, customer_id, product, amount, qty, currency_code, payment_status, created_at) VALUE('.$user_id.', "'.$txn_id.'", "'.$first_name.'", "'.$last_name.'", "'.$email.'", "'.$customer_id.'", "'.$product.'", "'.$amount.'", "'.$qty.'", "'.$currency_code.'", "'.$payment_status.'", NOW())  ;');

        if (!$pdostatement) {
            $msg = "\nPDO::errorInfo():\n";
            $msg .= print_r($this->errorInfo());
            return $msg;
        } else{
            $this->add_credit($user_id, $qty);
        }
    }

    public function add_credit($user_id, $qty) {
		$pdostatement = $this->query('SELECT balance FROM user WHERE id='.$user_id.';');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$actual_balance = $result['balance'];
		$new_balance = $actual_balance+$qty;
		$pdostatement = $this->query('UPDATE user SET balance='.$new_balance.' WHERE id='.$user_id.';');

		$this->check_balance($user_id);
    }

    public function check_balance($user_id){
		$pdostatement = $this->query('SELECT balance FROM user WHERE id='.$user_id.';');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$actual_balance = $result['balance'];

		$session = new session;
		    $session->balance = $actual_balance;
        }

}