<?php 

/**  
* @desc    
* examples 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  


class notification extends db_connect{

	public function new_order(){
		$server_name = $_SERVER['SERVER_NAME'];

		//------------------------------------ trouver le numero de la commande

		$pdostatement = $this->query('SELECT * FROM orders ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		
		$email = 'leanderfuchs@protonmail.com';
		$order_id = $result['id']; 		
		$patient_id = $result['patient_id']; 
		$product = $result['product_name']; 
		$teeth_nbr = $result['teeth_nbr']; 
		$quantity = $result['quantity']; 
		$vita_body = $result['vita_body']; 
		$vita3d_body = $result['vita3d_body']; 
		$return_date = $result['return_date'];
		$client_id = $result['user_ref_id']; 

		//------------------------------------ trouver le client
		$pdostatement = $this->query('SELECT id FROM user WHERE id="'.$client_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$client_id = $result['id']; 

		//------------------------------------ trouver les commantaires

		$pdostatement = $this->query('SELECT comment FROM comment WHERE order_ref_id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$comment = $result['comment'];
				
		//------------------------------------ email a open

		$to      = $email;
		$subject = 'www.opencfao.fr - Nouvelle commande ['.$order_id.']';
		
		$message = "";
		$message .= 'Bonjour'."\r\n"."\r\n";
		$message .= 'La commande #['.$order_id.'] à été passée sur www.opencfao.fr '."\r\n"."\r\n";
		$message .= 'Client: '.$client_id."\r\n";
		$message .= 'Patient: '.$patient_id."\r\n";
		$message .= 'Produit: '.$product.', quantité:'.$quantity."\r\n";
		$message .= 'Dents: '.$teeth_nbr."\r\n";
		$message .= 'Teinte: ' .$vita_body.$vita3d_body. "\r\n";
		$message .= 'Retour souhaité: '.$return_date."\r\n"."\r\n";
		if (!empty($comment)) {
			$message .= 'Commentaire: '.$comment."\r\n"."\r\n";
		} 
		
		$message .= 'Lien vers cette commande: '. $server_name .'/?page=order_detail&id='.$order_id."\r\n"."\r\n";

		$message .= 'Open CFAO.'."\r\n"."\r\n";
		$message .= 'www.opencfao.fr';
		$headers = 'From: donotreply@me.com' . "\r\n" .
		'Reply-To: donotreply@me.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

	} // end new order function



	public function client_new_order($user_id){
		$server_name = $_SERVER['SERVER_NAME'];

		//------------------------------------ trouver les info de cette utilisateur

		$pdostatement = $this->query('SELECT name, email FROM user WHERE id="'.$user_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$username = $result['name'];
		$email = $result['email'];


		//------------------------------------ trouver le numero de la commande

		$pdostatement = $this->query('SELECT id FROM orders ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$order_id = $result['id'];

		//------------------------------------ trouver les commantaires

		$pdostatement = $this->query('SELECT comment FROM comment WHERE order_ref_id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$comment = $result['comment'];

		//------------------------------------ trouver les informations liees a cette commande

		$pdostatement = $this->query('SELECT * FROM orders WHERE id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$patient_id = $result['patient_id']; 
		$teeth_nbr = $result['teeth_nbr']; 
		$quantity = $result['quantity']; 
		$vita_body = $result['vita_body']; 
		$vita3d_body = $result['vita3d_body']; 
		$return_date = $result['return_date']; 
		$product = $result['product_name']; 

		//------------------------------------ email au client

		$to      = $email;
		$subject = ' - Nouvelle commande ['.$order_id.']';
		
		$message = "";
		$message .= 'Bonjour '. $username .','."\r\n"."\r\n";
		$message .= 'Nous avons bien pris note de votre commande #['.$order_id.'] sur www.opencfao.fr et nous vous remercions de votre confiance.'."\r\n"."\r\n";
		$message .= 'Patient: '.$patient_id."\r\n";
		$message .= 'Dents: '.$teeth_nbr."\r\n";
		$message .= 'Produit: '.$product.', quantité:'.$quantity."\r\n";		
		$message .= 'Teinte: ' .$vita_body.$vita3d_body. "\r\n";
		$message .= 'Retour souhaité: '.$return_date."\r\n"."\r\n";
		if (!empty($comment)) {
			$message .= 'Commentaire: '.$comment."\r\n"."\r\n";
		} 
		

		$message .= 'Lien vers cette commande: '. $server_name .'/?page=order_detail&id='.$order_id."\r\n"."\r\n";

		$message .= 'Cordialement,'."\r\n";
		$message .= 'Open CFAO.'."\r\n"."\r\n";
		$message .= 'www.opencfao.fr';
		$headers = 'From: donotreply@me.com' . "\r\n" .
		'Reply-To: donotreply@me.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

	} // end add function


	public function supplier_new_order(){
		$server_name = $_SERVER['SERVER_NAME'];

		//------------------------------------ trouver le numero de la commande

		$pdostatement = $this->query('SELECT * FROM orders ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		
		$email = 'whitegem.dental@gmail.com';
		$order_id = $result['id']; 		
		$patient_id = $result['patient_id']; 
		$product = $result['product_name']; 
		$teeth_nbr = $result['teeth_nbr']; 
		$quantity = $result['quantity']; 
		$vita_body = $result['vita_body']; 
		$vita3d_body = $result['vita3d_body']; 
		$return_date = $result['return_date'];

		//------------------------------------ trouver les commantaires

		$pdostatement = $this->query('SELECT comment FROM comment WHERE order_ref_id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$comment = $result['comment'];
				
		//------------------------------------ email a fournisseur

		$to      = $email;
		$subject = ' - Nouvelle commande ['.$order_id.']';
		
		$message = "";
		$message .= 'Bonjour'."\r\n"."\r\n";
		$message .= 'Une nouvelle commande, #['.$order_id.'], à été passée sur www.opencfao.fr '."\r\n"."\r\n";
		$message .= 'Patient: '.$patient_id."\r\n";
		$message .= 'Produit: '.$product.', quantité:'.$quantity."\r\n";
		$message .= 'Dents: '.$teeth_nbr."\r\n";
		$message .= 'Teinte: ' .$vita_body.$vita3d_body. "\r\n";
		$message .= 'Retour souhaité: '.$return_date."\r\n"."\r\n";
		if (!empty($comment)) {
			$message .= 'Commentaire: '.$comment."\r\n"."\r\n";
		} 
		

		$message .= 'Lien vers cette commande: '. $server_name .'/?page=order_detail&id='.$order_id."\r\n"."\r\n";

		$message .= 'Open CFAO.'."\r\n"."\r\n";
		$message .= 'www.opencfao.fr';
		$headers = 'From: donotreply@me.com' . "\r\n" .
		'Reply-To: donotreply@me.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

	} // end new order function

	public function reminderEmail($order_id){
		$server_name = $_SERVER['SERVER_NAME'];
		$email = 'contact@missintooth.com';
				
		//------------------------------------ email a fournisseur

		$to      = $email;
		$subject = ' - Demande d\'information suplémentaire. ['.$order_id.']';
		
		$message = "";
		$message .= 'Bonjour'."\r\n"."\r\n";
		$message .= 'La commande #['.$order_id.'] nécessite l\'ajoute d\'informations complémentaires '."\r\n"."\r\n";
		
		$message .= 'Lien vers cette commande: '. $server_name .'/?page=order_detail&id='.$order_id."\r\n"."\r\n";

		$message .= 'Open CFAO.'."\r\n"."\r\n";
		$message .= 'www.opencfao.fr';
		$headers = 'From: donotreply@me.com' . "\r\n" .
		'Reply-To: donotreply@me.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

	} // end reminderEmail function


} // end cart class


























