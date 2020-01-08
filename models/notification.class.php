<?php 

/**  
* @desc    
* examples 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  


class notification extends db_connect{

	public function register ($email, $name){

		$to_email = $email;
		$from = "admin@dentech911.com";
		$from_name = "DenTech911.com";

		$main_title = "Votre compte a été créé";
		$short_description = "Félicitations, votre compte est activé et vous pouvez d’ors et déjà l'utiliser";

		$subject = "Bienvenue et merci d'être devenu membre de DenTech911!";
		$body = '	Bonjour '.$name.',</br>
					Je suis tellement heureux que vous ayez rejoint notre réseau.</br>
					J’ai inclus tous les détails de votre adhésion ci-dessous, ainsi qu\'une question que j\'ai à vous poser.</br></br>
					Mais d\'abord, voici quelques excellents avantages que vous obtenez en temp que membre : 50 points de téléchargement vous sont offerts en cadeau de bienvenue. De plus, vous aurez accès au système d\'échanges de fichiers le plus simple et intuitif possible et bien d\'autres choses encore à venir ... </br>
					Maintenant, voici les détails importants de votre adhésion:</br></br>
					Nom d\'utilisateur:  <b>'.$email.'</b></br>
					Niveau d\'adhésion: <b>Utilisateur</b></br>
					Mot de passe : celui que vous avez créé</br></br>
					<h3>Et voici ma question :</h3>
					<b>Quelle est la première raison pour laquelle vous vous êtes inscrit ?</b></br>
					Si vous pouviez répondre à cet e-mail, cela m\'aidera à créer une application plus personnalisée et à vous diriger vers le bon endroit.</br></br>
					En attendant, si vous souhaitez commencer à accéder à certaines de nos ressources exclusives, visitez notre espace réservé aux membres ici : https://www.dentech911.com.</br></br>
					Si vous avez des questions, j\'aimerais avoir de vos nouvelles. Répondez simplement à cet e-mail ou envoyez moi un message Telegram : https://t.me/dentech911.</br></br>
					Meilleurs succès et j\'espère que vous utiliserez DenTech911 quotidiennement !!</br>
					Leander';
		$mail = new mail;
		$mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);
		return $mail;
	}
	
	public function newpasswrd($to_email, $newpasswrd) {

		$from = "admin@dentech911.com";
		$from_name = "DenTech911.com";

		$main_title = "Votre nouveau mot de passe à été créé";
		$short_description = "Afin de garantir la securité de notre système, nous avons créé votre mot de passe";

		$subject = "Ceci est votre nouveau mot de passe : <b>" . $newpasswrd . '</b>';
		$body = '	Votre mot de passe sert à protéger les informations que vous laissez sur DenTech911.</br></br>
					Il est donc important pour vous de le garder, soit dans un carnet papier, soit dans la mémoire de votre navigateur favori, soit dans un système de sauvgarde décentralisé tel https://www.lastpass.com que nous recommandons fortement.</br></br>
					Vous souhaitant une excellente journée,</br>
					Leander';

		$mail = new mail;
		$mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);
		return $mail;
	}

	public function new_email($email, $generated_password){
		
		$server_name = $_SERVER['SERVER_NAME'];
		$to_email = $email;
		$from = "admin@dentech911.com";
		$from_name = "DenTech911.com";

		$main_title = "Félicitations, vous venez de recevoir une nouvelle commande !";
		$short_description = "Un membre de DenTech911 vient de vous envoyer une commande avec des scans 3D";

		$subject = 'Bienvenue sur DenTech911, la plateforme d\'échange de fichiers numériques entre professionnels du dentaire';
		$body = '	Bonjour, </br>
					Félicitations, une nouvelle commande vous a été envoyée sur DenTech911 !</br>
					Voici quelques excellents avantages que vous obtenez en temp que membre : 50 points de téléchargement vous sont offerts en cadeau de bienvenue. De plus, vous aurez accès au système d\'échanges de fichiers le plus simple et intuitif possible et bien d\'autres choses encore à venir ... </br>
					Maintenant, voici les détails importants de votre adhésion :</br></br>
					<h3>Comme nous n\'avons pas trouvé votre email dans notre base de données, votre compte a été créé et vos identifiants sont :</h3>
					Nom d\'utilisateur: <b>'. $email. '</b></br>
					Niveau d\'adhésion: <b>Utilisateur</b></br>
					Mot de passe: <b>'. $generated_password .'</b></br>
					Vous allez recevoir un deuxième email avec les détails de la commande.</br></br>
					Si vous avez des questions, j\'aimerais avoir de vos nouvelles. Répondez simplement à cet e-mail ou envoyez moi un message sur Telegram : https://t.me/dentech911 .</br></br>
					Meilleurs succès et j\'espère que vous utiliserez DenTech911 quotidiennement !</br>
					Leander</br>
					https://dentech911.com/';
		
		$mail = new mail;
		$mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);
		return $mail;
	}

	public function new_comment($from_user_name, $to_user_email, $comment, $order_id, $patient_id){

		$to_email = $to_user_email;
		$from = "admin@dentech911.com";
		$from_name = $from_user_name;

		$main_title = "			Commande: ". $patient_id;
		$short_description = '	Notre messagerie est le plus simple système d’échange pour les professionnels du dentaire car chaque message 						correspond à un cas particulier. </br>
								Vous n\'avez plus à rechercher dans votre boîte- mail le message correspondant à tel ou tel cas.';

		$subject = '			Nouveau message de <b>'.$from_user_name.'</b> concernant la commande : <b>'.$patient_id.'</b>';
		$body = '				Message: </br></br>
								<p><b>'. $comment.'</b></p></br></br>
								Lien vers ce message: https://www.dentech911.com/?page=order_detail&id='.$order_id;

		$mail = new mail;
		$mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);
	}

	public function admin_notification_new_order(){

		//------------------------------------ Find Order details
		$pdostatement = $this->query('SELECT * FROM orders ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$order_id = $result['id']; 		
		$client_id = $result['user_ref_id'];
		$supplier_id = $result['supplier_ref_id'];

		//------------------------------------ Find Client email
		$pdostatement = $this->query('SELECT email FROM user WHERE id="'.$client_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$client_email = $result['email']; 
		//------------------------------------ Find Supplier email
		$pdostatement = $this->query('SELECT email FROM user WHERE id="'.$supplier_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$supplier_email = $result['email'];

		//------------------------------------ Find Admin email
		$pdostatement = $this->query('SELECT email FROM user WHERE type="admin";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$admin_email = $result['email'];

		$from = "admin@dentech911.com";
		$to_email = $admin_email;
		$from_name = 'dentech911.com';

		$main_title = "New Order from ". $client_email;
		$short_description = 'A new order has been initiated';

		$subject = 'A new order has been initiated. Order ID='.$order_id.'</b>';
		$body = '	Great !</br> 
					New order on DenTech911 !!!</br>
					From: '.$client_email.' to '.$supplier_email;

		$mail = new mail;
		$mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);

	} 


	public function supplier_notification_new_order($supplier_user_id, $client_user_id){
		
		$server_name = $_SERVER['SERVER_NAME'];

		//------------------------------------ Find infos about this supplier
		$pdostatement = $this->query('SELECT email FROM user WHERE id="'.$supplier_user_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$supplier_email = $result['email'];

		//------------------------------------ Find infos about the client
		$pdostatement = $this->query('SELECT email FROM user WHERE id="'.$client_user_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$client_email = $result['email'];

		//------------------------------------ Find this order id
		$pdostatement = $this->query('SELECT * FROM orders ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$order_id = $result['id'];
		$patient_id = $result['patient_id']; 
		$teeth_nbr = $result['teeth_nbr']; 
		$quantity = $result['quantity']; 
		$vita_body = $result['vita_body']; 
		$vita3d_body = $result['vita3d_body']; 
		$return_date = $result['return_date']; 
		$product = $result['product_name']; 

		//------------------------------------ Find order comment
		$pdostatement = $this->query('SELECT comment FROM comment WHERE order_ref_id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$comment = $result['comment'];

		//------------------------------------ email au user

		$from = 'admin@dentech911.com';
		$to_email = $supplier_email;
		$from_name = 'DenTech911';

		$main_title = "Nouvelle commande: ". $patient_id;
		$short_description = 'Une nouvelle commande vous a été envoyée et vous attend sur DenTech911.';

		$subject = 'Vous avez reçu une nouvelle commande. ['.$order_id.']';
		$body = '	<p>Félicitations !</p> 
					'.$client_email.' vient de vous envoyer la commande pour : '.$patient_id.'</p>
					<h3>Détails :</h3>
					<p>Produit : <b>'.$product.'</b></p>
					<p>Dent(s) : <b>'.$teeth_nbr.'</b></p>
					<p>Quantité : <b>'.$quantity.'</b></p>
					<p>Teinte : <b>'.$vita_body.$vita3d_body.'</b></p>
					<p>Date de retour souhaitée : <b>'.$return_date.'</b></p>
					<p>Commentaire : '.$comment.'</p></br>
					<p>Lien vers cette commande : <a href="'. $server_name .'/?page=order_detail&id='.$order_id.'">'. $server_name .'/?page=order_detail&id='.$order_id.'</a></p>';

		$mail = new mail;
		$mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);
		return $mail;
		
	} // end add function

	public function client_notification_new_order($supplier_user_id, $client_user_id){
		
		$server_name = $_SERVER['SERVER_NAME'];

		//------------------------------------ Find infos about this supplier
		$pdostatement = $this->query('SELECT email FROM user WHERE id="'.$supplier_user_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$supplier_email = $result['email'];

		//------------------------------------ Find infos about the client
		$pdostatement = $this->query('SELECT email FROM user WHERE id="'.$client_user_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$client_email = $result['email'];

		//------------------------------------ Find this order id
		$pdostatement = $this->query('SELECT * FROM orders ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$order_id = $result['id'];
		$patient_id = $result['patient_id']; 
		$teeth_nbr = $result['teeth_nbr']; 
		$quantity = $result['quantity']; 
		$vita_body = $result['vita_body']; 
		$vita3d_body = $result['vita3d_body']; 
		$return_date = $result['return_date']; 
		$product = $result['product_name']; 

		//------------------------------------ Find order comment
		$pdostatement = $this->query('SELECT comment FROM comment WHERE order_ref_id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$comment = $result['comment'];

		//------------------------------------ email au user

		$from = 'admin@dentech911.com';
		$to_email = $client_email;
		$from_name = 'DenTech911';

		$main_title = 'Confirmation de votre commande: '. $patient_id;
		$short_description = 'Merci de faire confiance a DenTech911 pour l\'envoi et le stockage de vos fichiers';

		$subject = 'Votre commande est bien arrivée et un email de notification a été envoyé à '.$supplier_email;
		$body = '	<p>Ceci est un email de confirmation que votre commande a été envoyée.</p> 
					<i>Les informations sur cette commande étant disponibles en ligne, vous pouvez supprimer ce message</i> 

					<h3>Détails :</h3>
					<p>Déstinataire : <b>'.$supplier_email.'</b></p>
					<p>Produit : <b>'.$product.'</b></p>
					<p>Dent(s) : <b>'.$teeth_nbr.'</b></p>
					<p>Quantité : <b>'.$quantity.'</b></p>
					<p>Teinte : <b>'.$vita_body.$vita3d_body.'</b></p>
					<p>Date de retour souhaitée : <b>'.$return_date.'</b></p>
					<p>Commentaire : '.$comment.'</p></br>
					<p>Lien vers cette commande : <a href="'. $server_name .'/?page=order_detail&id='.$order_id.'">'. $server_name .'/?page=order_detail&id='.$order_id.'</a></p>';

		$mail = new mail;
		$mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);

	} // end add function	

	public function invite_email($user_id, $to_email){
		$to_email = htmlentities($to_email);

		// find who wants to send the invit
		$pdostatement = $this->query('SELECT email FROM user WHERE id=' .$user_id. ';');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$sender_email = $result['email'];

		// create message
		$from = 'admin@dentech911.com';
		$from_name = "DenTech911.com";

		$main_title = "Invitation à rejoindre DenTech911";
		$short_description = "DenTech911 est une plate-forme d'envoi de fichiers entre professionnels du dentaire";

		$subject = "Une invitation vous a été envoyée de ". $sender_email;
		$body = '<p>Bonjour</p>

		<p>Ceci est une invitation à vous inscrire sur la plate-forme d’échange DenTech911 afin que vous puissiez envoyer ou recevoir des commandes en ligne, avec leurs fichiers attachés, et avec votre contact dont l\'email est :' .$sender_email.'.</p>

		<p>Si vous souhaitez commencer à travailler en utilisant DenTech911 au lieu d\'emails, rendez-vous sur https://www.dentech911.com .</p>

		<p>Si vous avez des questions, répondez simplement à cet e-mail ou envoyez moi un message Telegram : https://t.me/dentech911 .</p>

		<p>Meilleurs succès et j\'espère que vous utiliserez DenTech911 quotidiennement !</br>
		Leander</p>';
		
		// send invite
		$mail = new mail;
		$mail_sent_email = $mail->send_mail($from, $from_name, $to_email, $main_title, $short_description, $subject, $body);
		return $mail;
	}

} // end cart class