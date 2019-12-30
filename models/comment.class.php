<?php 

/**  
* @desc Avis 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  


class comment extends db_connect{

	public function new ($user_id, $order_id, $comment){

		$comment = htmlspecialchars($comment);

		//------------------------------------ enregistrement
		$pdostatement = $this->query('INSERT INTO comment (date, user_ref_id, order_ref_id, comment) VALUES (NOW(), "'.$user_id.'", "'.$order_id.'","'.$comment.'");');

		// Find the sender's name
		$pdostatement = $this-query('SELECT name FROM user WHERE id='.$user_id.';');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$from_user_name = $result['name'];

		// fetch order's details 
		$pdostatement = $this-query('SELECT * FROM orders WHERE id='.$order_id.';');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$patient_id = $result['patient_id'];
		$user_ref_id = $result['user_ref_id'];
		$supplier_ref_id = $result['supplier_ref_id'];

		// Check who is the sender of the message and who is the recipient
		if ($user_id == $user_ref_id) {
			$pdostatement = $this-query('SELECT email FROM user WHERE id='.$user_ref_id.';');
			$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
			$to_user_email = $result['email'];

		} elseif ($user_id == $supplier_ref_id) {
			$pdostatement = $this-query('SELECT email FROM user WHERE id='.$supplier_ref_id.';');
			$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
			$to_user_email = $result['email'];
		}

		//------------------------------------ email
		$notification = new notification;
		$this->notification->new_comment($from_user_name, $to_user_email, $comment, $order_id, $patient_id);

		return TRUE;

	} // end add function

	public function comment_list($order_id, $user_id){
		$comment = '';
		//------------------------------------ trouver l'ID de l'utilisateur
		$pdostatement = $this->query('SELECT type FROM user WHERE id = "' . $user_id . '";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$type = $result['type'];
		//------------------------------------ fetch messages
		$pdostatement = $this->query('SELECT * FROM comment WHERE order_ref_id="'.$order_id.'" ORDER BY date ASC;');
		$pdostatement->execute();
		return $comments = $pdostatement->fetchAll();
	} // end add function

	public function first_comment ($order_id){

		$pdostatement = $this->query('SELECT comment FROM comment WHERE order_ref_id="'.$order_id.'" ORDER BY id ASC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		return $comment_id = $result['comment']; 

	} // end add function



} // end cart class