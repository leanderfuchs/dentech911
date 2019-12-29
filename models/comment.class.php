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

		//------------------------------------ email

		$to      = 'leanderfuchs@protonmail.com';
		$subject = 'Dentech911 - Nouveau message concernant la commande ['.$order_id.'].';
		$message = 'Message: '."\r\n". $comment."\r\n"."\r\n";
		$message .= 'Lien: '. $_SERVER['SERVER_NAME'] .'?page=message_board&id='.$order_id;
		$headers = 'From: leanderfuchs@protonmail.com'."\r\n" .
		'Reply-To: leanderfuchs@protonmail.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

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