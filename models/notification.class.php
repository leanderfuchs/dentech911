<?php 

/**  
* @desc    
* examples 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  


class notification extends db_connect{

	private	$mail;

    public function __CONSTRUCT() {
        $this->mail = new mail;
    }

	public function register ($email, $name){

		$to_email = $email;
		$from = "contact@dentech911.com";
		$from_name = "DenTech911.com";

		$main_title = "Votre compte a été créé";
		$short_description = "Félicitation, votre compte est activé et vous pouvez dors et déjà l'utiliser";

		$subject = "Bienvenue et merci d'être devenu membre de DenTech911!";
		$body = '	Bonjour '.$name.',</br>
					Je suis tellement heureux que vous ayez rejoint notre réseau.</br>
					J\'ai inclus tous les détails de votre adhésion ci-dessous, ainsi qu\'une question que j\'ai à vous poser.</br></br>
					Mais d\'abord, voici quelques excellents avantages que vous obtenez en temp que membre: <b>50 points de téléchargement</b> vous sont offerts en cadeau de bienvenue. De plus, vous aurez accès au système d\'échanges de fichiers le plus simple et intuitif possible et bien d\'autres choses encore à venir ... </br>
					Maintenant, voici les détails importants de votre adhésion:</br></br>
					Nom d\'utilisateur: <b>'.$email.'</b></br>
					Niveau d\'adhésion: <b>Utilisateur</b></br>
					Mot de passe : celui que vous avez créé</br></br>
					<h3>Et voici ma question:</h3>
					<b>Quelle est la première raison pour laquelle vous vous êtes inscrit?</b></br>
					Si vous pouviez répondre à cet e-mail avec votre réponse, cela m\'aiderait à créer une application plus personnalié et à vous diriger vers le bon endroit.</br></br>
					En attendant, si vous souhaitez commencer à accéder à certaines de nos ressources exclusives, visitez notre espace réservé aux membres ici https://www.dentech911.com.</br></br>
					Si vous avez des questions, j\'aimerais avoir de vos nouvelles. Répondez simplement à cet e-mail ou envoyez moi un message Telegram : https://t.me/dentech911.</br></br>
					Meilleurs succès et j\'espère que vous utiliserez DenTech911 quotidienement!</br>
					Leander';

		$this->mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);
	}
	
	public function newpasswrd($to_email, $newpasswrd) {

		$from = "contact@dentech911.com";
		$from_name = "DenTech911.com";

		$main_title = "Votre nouveau mot de passe à été créé";
		$short_description = "Afin de guarantir la securité de notre système, nous avons créé votre mot de passe";

		$subject = "Ceci est votre nouveau mot de passe : <b>" . $newpasswrd . '</b>';
		$body = '	Votre mot de passe sert à protéger les informations que vous laissez sur DenTech911.</br></br>
					il est donc important pour vous de le garder, soit dans un carnet papier, soit dans la mémoire de votre navigateur favorit, soit dans un système de sauvgarde décentralisé tel <a href="https://lastpass.com/">lastpass</a> que nous recommandons fortemant</br></br>
					Vous souhaitant une excellente journée</br>
					Leander';

		$this->mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);
	}

	public function new_email($email, $generated_password){
		
		$to_email = $email;
		$from = "contact@dentech911.com";
		$from_name = "DenTech911.com";

		$main_title = "Félicitation, vous venez de recevoir une nouvvelle commande !";
		$short_description = "Un membre de DenTech911 vient de vous envoyer une commande avec des scans 3D";

		$subject = 'Bienvenue sur DenTech911, la platforme d\'échange de fichiers numérique entre proffessionels du dentaire';
		$body = '	Bonjour, </br>
					Félicitations, une nouvelle commande vous a été envoyée sur DenTech911 !</br>
					Voici quelques excellents avantages que vous obtenez en temp que membre: <b>50 points de téléchargement</b> vous sont offerts en cadeau de bienvenue. De plus, vous aurez accès au système d\'échanges de fichiers le plus simple et intuitif possible et bien d\'autres choses encore à venir ... </br>
					Maintenant, voici les détails importants de votre adhésion:</br></br>
					<h3>Comme nous n\'avons pas trouvé votre email dans notre base de données, votre compte a été créé et vos identifiants sont :</h3>
					Nom d\'utilisateur: <b>'. $email. '</b></br>
					Niveau d\'adhésion: <b>Utilisateur</b></br>
					Mot de passe : <b>'. $generated_password .'</b></br></br>
					Si vous avez des questions, j\'aimerais avoir de vos nouvelles. Répondez simplement à cet e-mail ou envoyez moi un message sur Telegram : https://t.me/dentech911.</br></br>
					Meilleurs succès et j\'espère que vous utiliserez DenTech911 quotidienement!</br>
					Leander';

		$this->mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);
	}

	public function new_comment($from_user_name, $to_user_email, $comment, $order_id, $patient_id){

		$to_email = $to_user_email;
		$from = "contact@dentech911.com";
		$from_name = $from_user_name;

		$main_title = "Commande: ". $patient_id;
		$short_description = '	Notre messagerie est le plus simple système d\'échange pour les professionnels du dentaire car chaque message 						corréspond à un cas particulier.</br>
								Vous n\'avez plus à rechercher dans votre boite mail le méssage correspondant à tel ou tel cas';

		$subject = 'Nouveau message de <b>'.$from_user_name.'</b> concernant la commande : <b>'.$patient_id.'</b>';
		$body = '	Message: </br></br>
					<p><b>'. $comment.'</b></p></br></br>
					Lien vers ce message: https://www.dentech911.com/?page=order_detail&id='.$order_id;

		$this->mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);
	}

	public function new_order(){
		$server_name = $_SERVER['SERVER_NAME'];

		//------------------------------------ trouver le numero de la commande

		$pdostatement = $this->query('SELECT * FROM orders ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$order_id = $result['id']; 		
		$patient_id = $result['patient_id']; 
		$product = $result['product_name']; 
		$teeth_nbr = $result['teeth_nbr']; 
		$quantity = $result['quantity']; 
		$vita_body = $result['vita_body']; 
		$vita3d_body = $result['vita3d_body']; 
		$return_date = $result['return_date'];
		$client_id = $result['user_ref_id'];
		$supplier_id = $result['supplier_ref_id'];

		//------------------------------------ trouver le user
		$pdostatement = $this->query('SELECT name FROM user WHERE id="'.$client_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$client_name = $result['name']; 
		//------------------------------------ trouver le supplier
		$pdostatement = $this->query('SELECT email FROM user WHERE id="'.$supplier_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$email = $result['email'];

		//------------------------------------ trouver les commantaires

		$pdostatement = $this->query('SELECT comment FROM comment WHERE order_ref_id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$comment = $result['comment'];
				
		//------------------------------------ email a open

		$to      = $email;
		$subject = 'www.dentech911.com - Nouvelle commande ['.$order_id.']';
		
		$message = 'Bonjour,'."\r\n\r\n";
		$message .= 'La commande #['.$order_id.'] à été passée sur www.dentech911.com'."\r\n\r\n";
		$message .= 'De: '.$client_name."\r\n";
		$message .= 'Patient: '.$patient_id."\r\n";
		$message .= 'Produit: '.$product.', quantité:'.$quantity."\r\n";
		$message .= 'Dents: '.$teeth_nbr."\r\n";
		$message .= 'Teinte: ' .$vita_body.$vita3d_body. "\r\n";
		$message .= 'Retour souhaité: '.$return_date."\r\n"."\r\n";
		if (!empty($comment)) {
			$message .= 'Commentaire: '.$comment."\r\n"."\r\n";
		} 
		
		$message .= 'Lien vers ce message: https://www.dentech911.com/?page=order_detail&id='.$order_id."\r\n"."\r\n";

		$message .= 'DenTech911.'."\r\n"."\r\n";
		$message .= 'www.dentech911.com';
		$headers = 'From: leanderfuchs@protonmail.com' . "\r\n" .
		'Reply-To: leanderfuchs@protonmail.com' . "\r\n" .
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

		//------------------------------------ email au user

		$to      = $email;
		$subject = ' - Nouvelle commande ['.$order_id.']';
		
		$message = "";
		$message .= 'Bonjour '. $username .','."\r\n"."\r\n";
		$message .= 'Nous avons bien pris note de votre commande #['.$order_id.'] sur www.dentech911.com et nous vous remercions de votre confiance.'."\r\n"."\r\n";
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
		$message .= 'DenTech911.'."\r\n"."\r\n";
		$message .= 'www.dentech911.com';
		$headers = 'From: leanderfuchs@protonmail.com' . "\r\n" .
		'Reply-To: leanderfuchs@protonmail.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

	} // end add function


	public function supplier_new_order(){
		$server_name = $_SERVER['SERVER_NAME'];

		//------------------------------------ trouver le numero de la commande

		$pdostatement = $this->query('SELECT * FROM orders ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$email = $user->user_query($result['id'],'email');
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
		$message .= 'Une nouvelle commande, #['.$order_id.'], à été passée sur www.dentech911.com '."\r\n"."\r\n";
		$message .= 'Patient: '.$patient_id."\r\n";
		$message .= 'Produit: '.$product.', quantité:'.$quantity."\r\n";
		$message .= 'Dents: '.$teeth_nbr."\r\n";
		$message .= 'Teinte: ' .$vita_body.$vita3d_body. "\r\n";
		$message .= 'Retour souhaité: '.$return_date."\r\n"."\r\n";
		if (!empty($comment)) {
			$message .= 'Commentaire: '.$comment."\r\n"."\r\n";
		} 
		

		$message .= 'Lien vers cette commande: '. $server_name .'/?page=order_detail&id='.$order_id."\r\n"."\r\n";

		$message .= 'DenTech911.'."\r\n"."\r\n";
		$message .= 'www.dentech911.com';
		$headers = 'From: leanderfuchs@protonmail.com' . "\r\n" .
		'Reply-To: leanderfuchs@protonmail.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

	} // end new order function

	public function reminderEmail($order_id){
		$server_name = $_SERVER['SERVER_NAME'];
		$email = 'leanderfuchs@protonmail.com';
				
		//------------------------------------ email a fournisseur

		$to      = $email;
		$subject = ' - Demande d\'information suplémentaire. ['.$order_id.']';
		
		$message = 'Bonjour'."\r\n"."\r\n";
		$message .= 'La commande #['.$order_id.'] nécessite l\'ajoute d\'informations complémentaires '."\r\n"."\r\n";
		$message .= 'Lien vers cette commande: '. $server_name .'/?page=order_detail&id='.$order_id."\r\n"."\r\n";
		$message .= 'DenTech911.'."\r\n"."\r\n";
		$message .= 'www.dentech911.com';

		$headers = 'From: leanderfuchs@protonmail.com' . "\r\n" .
		'Reply-To: leanderfuchs@protonmail.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

	} // end reminderEmail function

	//------------------------------------ If user send points to an unknown email address
	public function send_points_new_email($email){
		$server_name = $_SERVER['SERVER_NAME'];
		$to      = $email;
		$subject = 'DenTech911 - Une nouvelle commande vous attend sur www.dentech911.com .';
		
		$message = 'Bonjour, '. "\r\n" .
		$message .= 'Félicitations, une nouvelle commande vous a été envoyée sur DenTech911 !'."\r\n\r\n";
		$message .= 'Aussi, comme nous n\'avons pas trouvé votre email dans notre base de données, votre compte a été créé et vos déifiants sont votre adresse email et ce mot de passe que nous avons généré pour vous : '. $generated_password;
		
		$headers = 'From: leanderfuchs@protonmail.com' . "\r\n" .
		'Reply-To: leanderfuchs@protonmail.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

	} // end reminderEmail function


} // end cart class