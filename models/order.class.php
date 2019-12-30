<?php 

/**  
* @desc    
* examples 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  


class order extends db_connect{

	public function product($user_id, $patient, $teeth_nbr, $product, $vita_body, $vita3d_body, $implant_name, $implant_diam, $comment, $return_date, $unique_order_key, $supplier_user_id){
		
		$msg = '';
		$username = $_SESSION['Auth'];

		$patient = htmlspecialchars($patient);
		$teeth_nbr = htmlspecialchars($teeth_nbr);
		$product = htmlspecialchars($product);
		$vita_body = htmlspecialchars($vita_body);
		$vita3d_body = htmlspecialchars($vita3d_body);
		$implant_name = htmlspecialchars($implant_name);
		$implant_diam = htmlspecialchars($implant_diam);
		$comment = htmlspecialchars($comment);
		$return_date = htmlspecialchars($return_date);

				//------------------------------------ set return date

		if (empty($return_date)) {
			$return_date = mktime(0,0,0,date("m"),date("d")+5,date("Y"));
			$return_date = date("Y-m-d", $return_date);
		} 

				//------------------------------------ trouver les infos du user

		$pdostatement = $this->query('SELECT email, name FROM user WHERE id = "' . $user_id . '";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$user_email = $result['email'];
		$user_name = $result['name'];

				//------------------------------------ trouver l'ID du produit

		$pdostatement = $this->query('SELECT id FROM product WHERE name = "' . $product . '";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$product_id = $result['id'];

		//------------------------------------ compter le nombre de dents
		$quantity = substr_count($teeth_nbr, ' ')+1;

		//------------------------------------ Ajouter la commande dans la DB

		$pdostatement = $this->query('INSERT INTO orders (
			arrival_date,return_date,user_ref_id,patient_id,status,paiment_status,comment,teeth_nbr,product_name,quantity,vita_body,vita3d_body,implant_name,implant_diam,unique_order_key, supplier_ref_id) 
		VALUES (
			NOW(),"'.$return_date.'","'.$user_id.'","'.$patient.'","Commande envoyée","0","'.$comment .'","'.$teeth_nbr.'","'.$product.'","'.$quantity.'","'.$vita_body.'","'.$vita3d_body.'","'.$implant_name.'","'.$implant_diam.'","'. $unique_order_key .'", "'.$supplier_user_id.'");');


		//------------------------------------ trouver le numero de la commande

		$pdostatement = $this->query('SELECT id FROM orders ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$order_id = $result['id']; 

		//------------------------------------ Creer un evenement

		$pdostatement = $this->query('INSERT INTO case_track (case_ref_id, username, time, localization, status) VALUES ("'.$order_id.'", "'.$user_name.'", NOW(), "Transporteur" , "Commande envoyée");');

		//------------------------------------ Creer un commentaire
		
		if ($comment!='') {
			
			$comment = htmlspecialchars($comment);

			$pdostatement = $this->query('INSERT INTO comment (date, user_ref_id, order_ref_id, comment) VALUES (NOW(), "'.$user_id.'", "'.$order_id.'","'.$comment.'");');
		}

		//------------------------------------ Notifications
		$notification = new notification;
		$notification->client_new_order($_SESSION['user_id']);
		$notification->new_order();
		
	} // end add function

	public function add_file($unique_order_key, $file_nbr, $tmp_name, $file_clean_name){

		$pdostatement = $this->query('SELECT * FROM orders WHERE unique_order_key="'.$unique_order_key.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$msg = '';
		$order_id = $result['id'];
		$client_id = $result['user_ref_id'];
		$patient = $result['patient_id'];
		$teeth = $result['teeth_nbr'];
		$product = $result['product_name'];
		$shade = $result['vita_body'].$result['vita3d_body'];
		$date_time = date('D_F_Y_H-i-s');
		$date = date('D_M_Y');

		//------------------------------------ find user's name
		$pdostatement = $this->query('SELECT name FROM user WHERE id="'.$client_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$unwanted = array(" ", ".", "-", "_", ",", "/", "+", "#", ";");
		$client_name = strtolower(str_replace($unwanted, "_", $result['name']));
		$patient = strtolower(str_replace($unwanted, "_", $patient));
		$teeth = strtolower(str_replace($unwanted, "_", $teeth));
		$product = strtolower(str_replace($unwanted, "_", $product));
		$shade = strtolower(str_replace($unwanted, "_", $shade));

		$save_file = $client_name.'-'.$patient.'-'.$teeth.'_'.$product.'_'.$shade.'_'.$date_time.'-'.$file_clean_name;
		$sha1_save_file = SHA1($save_file);
		$file_path = 'orders/files/'.$client_name.'/'.$date.'/';

		if (!file_exists($file_path)) mkdir($file_path, 0777, TRUE);
		$file_url = $file_path . $sha1_save_file;

		move_uploaded_file($tmp_name, $file_url);

		//------------------------------------ Ajouter les fichiers dans la DB

		$pdostatement = $this->query('INSERT INTO files (file_url, order_ref_id, order_file_name, file_hash) VALUES ("'. $file_url .'", "'.$order_id.'", "'.$save_file.'", "'.$sha1_save_file.'") ;');

		if (!$pdostatement) {
		   $msg .= "\nPDO::errorInfo():\n";
		   $msg = print_r($this->errorInfo());
		}
	} // end add function

	public function download_file($file_hash, $user_id){
		
		// check if file is locked
		$pdostatement = $this->query('SELECT unlocked from files WHERE file_hash="'.$file_hash.'"');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$file_lock_status = $result['unlocked'];
		
		// if the file is locked
		if ($file_lock_status == 0){
			//remove one point from user
			$this->query('UPDATE user SET balance = balance - 1 WHERE id='.$user_id.';');	
			//unlock the file
			$this->query('UPDATE files SET unlocked = 1;');
		} 
		//return the file download URL
		$pdostatement = $this->query('SELECT * from files WHERE file_hash="'.$file_hash.'"');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	public function caselist($user_id){

		$Convert_Dates = new Convert_Dates;

		//------------------------------------ trouver le type du membre
		$pdostatement = $this->query('SELECT type FROM user WHERE id = "' . $user_id . '";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$user_type = $result['type'];

		// If no order exists
		$pdostatement = $this->query('SELECT id FROM orders WHERE user_ref_id = "' . $user_id . '" ;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		if ($result['id']==NULL){
			//return '<span class=""><i>Vous n\'avez pas encore passé(e) de commande</i></span><br/>';
		}
		
		// Create orders table for the user
		$caselist = array();
		$pdostatement = $this->query('SELECT DISTINCT DATE(arrival_date) AS arrival_date FROM orders WHERE user_ref_id='.$user_id.' OR supplier_ref_id='.$user_id.' ORDER BY arrival_date DESC;');
		$caselist = $pdostatement->fetchAll();

		$count = 0;
		foreach ( $caselist as $arrival_date => $val) {
			
			$pdostatement = $this->query('SELECT * FROM orders WHERE (user_ref_id="'.$user_id . '" OR  supplier_ref_id='.$user_id.' ) AND DATE(arrival_date)="' . $val['arrival_date'].'" ORDER BY id DESC;');
			$order_details = $pdostatement->fetchAll();
			
			// add cases within each date
			$caselist[$arrival_date][] = $order_details;
			
			// Convert dates			
			$caselist[$arrival_date]['arrival_date'] = $Convert_Dates->longnames(date("l d F Y", strtotime($val["arrival_date"])));
		}
		return $caselist;
	} // end last_orders function


	public function details($order_id){

		//------------------------------------ textraire les detailles de la commande
		$pdostatement = $this->query('SELECT * FROM orders WHERE id="'.$order_id.'";');
		$order_details = $pdostatement->fetch(PDO::FETCH_ASSOC);

		if (!empty($order_details)) {
			$order_details = implode("|", $order_details);
		}

		return $order_details;

	} // end details_commande function

	public function details_from_unique_order_key($unique_order_key){

		//------------------------------------ textraire les detailles de la commande

		$pdostatement = $this->query('SELECT * FROM orders WHERE unique_order_key="'.$unique_order_key.'";');
		$order_details = $pdostatement->fetch(PDO::FETCH_ASSOC);


		if (!empty($order_details)) {
			$order_details = implode("|", $order_details);
		}
		//------------------------------------ Retrouver les id des produits de la commande
		
		return $order_details;

	} // end details_from_unique_order_key function


	public function details_opencfao($order_id){

		//------------------------------------ textraire les detailles de la commande

		$pdostatement = $this->query('SELECT u.name FROM orders o, user u WHERE o.id="'.$order_id.'" AND o.user_ref_id=u.id;');
		$client_name = $pdostatement->fetch(PDO::FETCH_ASSOC);

		//------------------------------------ Retrouver les id des produits de la commande
		
		return $client_name['name'];

	} // end details_commande function



	public function paid ($order_id){

		//------------------------------------ textraire les detailles de la commande

		$pdostatement = $this->query('UPDATE orders SET paiment_status = "1" WHERE id="' . $order_id . '";');

		//------------------------------------ Retrouver les id des produits de la commande
		
	} // end details_commande function


	public function status ($status, $unique_order_key){

		$msg = '';

		if ($status == "Commande envoyée") $localization = "Transporteur";
		if ($status == "Reçu chez DenTech911") $localization = "DenTech911";
		if ($status == "Envoyée en production") $localization = "Centre de Fraisage";
		if ($status == "En cours de production") $localization = "Centre de Fraisage";
		if ($status == "En retour de production") $localization = "Transporteur";
		if ($status == "Prète à être livrée") $localization = "DenTech911";
		if ($status == "En cours de livraison") $localization = "Transporteur";
		if ($status == "Livrée") $localization = "user";

				//------------------------------------ Trouver le status actuelle

		$pdostatement = $this->query('SELECT * FROM orders WHERE unique_order_key="'.$unique_order_key.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$current_status = $result['status'];
		$order_id = $result['id'];
		$username = $_SESSION['Auth'];

				//------------------------------------ Verification du status actuel

		if ($current_status !== $status) {
				
					//------------------------------------ Mise a jour du status

			$pdostatement = $this->query('UPDATE orders SET status = "'.$status.'" WHERE unique_order_key="' . $unique_order_key . '";');

					//------------------------------------ Creer un evenement

			$pdostatement = $this->query('INSERT INTO case_track (case_ref_id, username, time, localization, status) VALUES ("' . $order_id . '", "' . $username . '", NOW(), "'.$localization.'", "'.$status.'");');		

					//------------------------------------ Messages

			$msg .= '<div class="valide"> Le status du cas [<b>' . $order_id . '</b>] a été changé pour "<b>' . $status . '</b>"</div>';
		}

		return $msg;

	} // end add function


	public function track ($order_id){

		$Convert_Dates = new Convert_Dates;

		$result = '';
		//------------------------------------ textraire les detailles de la commande

		$query = 'SELECT * FROM case_track WHERE case_ref_id="' . $order_id . '";';

		//------------------------------------ Retrouver les id des produits de la commande
		foreach ($this->query($query) as $stack) {
			$result.= '<tr>';
			$result.= '<td>'.$stack['username'].'</td>';
			$result.= '<td>'.$Convert_Dates->shortnames(date("l d F Y H:i", strtotime($stack['time']))).'</td>';
			$result.= '<td>'.$stack['status'].'</td>';
			$result.= '<td>'.$stack['localization'].'</td>';
			$result.= '</tr>';
		}

		return $result;

	} // end add function

	public function update_status($user_name, $order_id){

		$available = "";
		$avalable_status = "";
		//------------------------------------ find order status
		
		$pdostatement = $this->query('SELECT status FROM orders WHERE id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$current_status = $result['status'];

		//------------------------------------ find user type

		$pdostatement = $this->query('SELECT type FROM user WHERE name="'.$user_name.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);		
		$user_type = $result['type'];
		

		//------------------------------------ Creation ses differents status

		$status = array('Commande envoyée', 'Reçu chez DenTech911', 'Envoyée en production', 'En cours de production','En retour de production', 'Prète à être livrée', 'En cours de livraison', 'Livrée');

		//------------------------------------ Trouver la clef qui correspond au status actuel
	
		foreach ($status as $key => $value) {

			if ($value==$current_status) {
				$available=$key;
			}

		}

		//------------------------------------ To prevent from removing the Livrée status at the end. 
		if ($available<7){
			$available = $available+1;
		}
		
		//------------------------------------ Formulaire - Option Disponible:


		if ($user_type == 'admin'){

			$avalable_status .= '<div class="title"><h3>Changer de statut</h3></div>
				<form id="status" method="post">
				<select name="status">
				<option value="' . $status[$available] . '">' . $status[$available] . '</option>
				</select>
				<input type="submit" name="submit" value="mettre à jour le statut"></form>';
				
		} elseif ($user_type == 'user' AND ($current_status == $status['3'] OR $current_status == $status['6'])){

			$avalable_status .= '<div class="title"><h3>Changer de statut</h3></div>
				<form id="status" method="post">
				<select name="status">
				<option value="' . $status[$available] . '">' . $status[$available] . '</option>
				</select>
				<input type="submit" name="submit" value="mettre à jour le statut"></form>';
		
		} elseif ($user_type == 'Fournisseur' AND ($current_status == $status['2'] OR $current_status == $status['3'])){
			
			$avalable_status .= '<div class="title"><h3>Changer de statut</h3></div>
				<form id="status" method="post">
				<select name="status">
				<option value="' . $status[$available] . '">' . $status[$available] . '</option>
				</select> 
				<input type="submit" name="submit" value="mettre à jour le statut">
				</form>';	
		
		} 

		return $avalable_status; 

	} // end details_commande function



	public function traceability($order_id, $lot, $ref, $tracking){


		//------------------------------------ Mise a jour de la tracabilite
		
		$pdostatement = $this->query('UPDATE orders SET lot="'.$lot.'", ref="'.$ref.'", tracking="'.$tracking.'" WHERE id="'.$order_id.'";');

		$msg = '<div class="valide"> Les informations de traçabilités ont bien été ajoutés, merci.</div>';

		//------------------------------------ Trouver le status actuel

		$pdostatement = $this->query('SELECT status FROM orders WHERE id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$current_status = $result['status'];

		if (!empty($tracking) AND $current_status =="En cours de production") {
		
			//------------------------------------ Mise a jour du status

			$pdostatement = $this->query('UPDATE orders SET status = "En retour de production" WHERE id="' . $order_id . '";');

			//------------------------------------ Creer un evenement

			$pdostatement = $this->query('INSERT INTO case_track (case_ref_id, username, time, localization, status) VALUES ("' . $order_id . '", "Centre d\'usingage", NOW(), "Transporteur", "En retour de production");');
		}

		//------------------------------------ Add or update delivery table
		
		if (!empty($tracking)) {

			$pdostatement = $this->query('SELECT supplier_tracking_nbr FROM delivery WHERE order_ref_id = "' . $order_id . '" ;');
			$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
			$supplier_tracking_nbr = $result['supplier_tracking_nbr'];

			if (empty($supplier_tracking_nbr)) {
				$pdostatement = $this->query('INSERT INTO delivery (order_ref_id, supplier_tracking_nbr) VALUES ('. $order_id .', "'.$tracking.'");');
			} else {
				$pdostatement = $this->query('UPDATE delivery SET supplier_tracking_nbr = "'.$tracking.'" WHERE order_ref_id="' . $order_id . '";');
			}

		}

		return $msg;		

	} // end details_commande function


	public function send_prod ($order_id, $supplierID){

		$message = '';
		$msg = '';

		$pdostatement = $this->query('SELECT email FROM user WHERE id = "' . $supplierID . '" ;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$supplier_email = $result['email'];

		$pdostatement = $this->query('SELECT * FROM orders WHERE id = "' . $order_id . '" ;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$patient = $result['patient_id'];
		//------------------------------------ email de notification pour le supplier
		
		$to     = $supplier_email;
		$subject = 'DenTech911: Commande ['.$order_id.'] prête à être usinée.';

		$message .= 'Patient: '.$patient."\r\n";

		$message .= 'Bonjour,'."\r\n"."\r\n";
		$message .= 'Une nouvelle commande est p prête pour l\'usinage:['.$order_id.']'."\r\n"."\r\n";
		$message .= 'Pour acceder à la fiche, clicker sur le lien:';
		$message .= ''. $_SERVER['SERVER_NAME'] .'/?page=order_detail&id='.$order_id.'"> Lien vers la fiche de la commande'."\r\n"."\r\n";

		$message .= 'Merci,'."\r\n";
		$message .= 'DenTech911.'."\r\n"."\r\n";
		$message .= 'www.dentech911.com';

		$headers = 'From: leanderfuchs@protonmail.com' . "\r\n" . 'Reply-To: leanderfuchs@protonmail.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

			//------------------------------------ Trouver le status actuel

		$pdostatement = $this->query('SELECT status FROM orders WHERE id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$current_status = $result['status'];

		if ($current_status =="Reçu chez DenTech911" OR $current_status =="Commande envoyée") {
		
			//------------------------------------ Mise a jour du status

			$pdostatement = $this->query('UPDATE orders SET status = "Envoyée en production" WHERE id="' . $order_id . '";');

			//------------------------------------ Mise a jours du fournisseur
			$pdostatement = $this->query('UPDATE orders SET supplier_ref_id="'.$supplierID.'" WHERE id="' . $order_id . '";');

			
			//------------------------------------ Creer un evenement

			$pdostatement = $this->query('INSERT INTO case_track (case_ref_id, username, time, localization, status) VALUES ("' . $order_id . '", "DenTech911", NOW(), "Centre de Fraisage", "Envoyée en production");');
		}


		//------------------------------------ retourne le message 

		$msg .= '<div class="valide"> Le cas à été envoyé au centre d\'usinage.</div>';

		return $msg; 

	} // end details_commande function


	public function delete($order_id){
		
		$pdostatement = $this->query('DELETE FROM orders WHERE id="'.$order_id.'";');

			$msg = '<div class="valide"> la commande à été supprimée.</div>';
			header("Location: ?page=order_list"); /* Redirection du navigateur */

		return $msg; 

	} // end details_commande function

	public function auto_update_status($unique_order_key, $user_id){

		//------------------------------------ find order status
		
		$pdostatement = $this->query('SELECT status, file1 FROM orders WHERE unique_order_key="'.$unique_order_key.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$current_status = $result['status'];
		$file = $result['file1'];

		//------------------------------------ find user type

		$pdostatement = $this->query('SELECT type FROM user WHERE id="'.$user_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);		
		$user_type = $result['type'];
		
		//------------------------------------ find if a file has been submitted.

		if (!empty($file)) {$havefile=1;}
		
		//------------------------------------ Formulaire - Option Disponible:
		
		if ($user_type == 'Fournisseur' AND $current_status == "Envoyée en production" ){
			
			//------------------------------------ Mise a jour du status

			$pdostatement = $this->query('UPDATE orders SET status = "En cours de production" WHERE id="' . $order_id . '";');

			//------------------------------------ Creer un evenement

			$pdostatement = $this->query('INSERT INTO case_track (case_ref_id, username, time, localization, status) VALUES ("' . $order_id . '", "Centre d\'usingage", NOW(), "Centre de Fraisage", "En cours de production");');
		}

		if ($user_type == 'DenTech911' AND $current_status == "Commande envoyée" AND $havefile==1){
			
			//------------------------------------ Mise a jour du status

			$pdostatement = $this->query('UPDATE orders SET status = "Reçu chez DenTech911" WHERE id="' . $order_id . '";');

			//------------------------------------ Creer un evenement

			$pdostatement = $this->query('INSERT INTO case_track (case_ref_id, username, time, localization, status) VALUES ("' . $order_id . '", "DenTech911", NOW(), "DenTech911", "Reçu chez DenTech911");');
		}

	} // end auto_update_status function

	public function get_order_key_with_id($order_id) {
		$pdostatement = $this->query('SELECT unique_order_key FROM orders WHERE id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);		
		$result = $result['unique_order_key'];
		return $result;
	}

	public function get_last_order_unique_key() {
		$pdostatement = $this->query('SELECT unique_order_key FROM orders ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		return $result['unique_order_key'];
	}

	public function order_query($unique_order_key, $query) {
		$pdostatement = $this->query('SELECT '.$query.' FROM orders WHERE unique_order_key="'.$unique_order_key.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$result = $result[$query];
		return $result;
	}

	public function file_query($file_hash, $query) {
		$pdostatement = $this->query('SELECT '.$query.' FROM files WHERE file_hash="'.$file_hash.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);		
		$result = $result[$query];
		return $result;
	}

	public function get_files($order_id) {
		$files = [];

		$pdostatement = $this->query('SELECT * from files WHERE order_ref_id='. $order_id .';');
		$pdostatement->execute();
		return $all_files = $pdostatement->fetchAll();
	}

	public function restricted_page($user_id, $order_id){
		$pdostatement = $this->query('SELECT user_ref_id FROM orders WHERE id='.$order_id.';');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$order_user_id = $result['user_ref_id'];

		if($user_id == $order_user_id){
			return 0;
		} else {
			return 1;
		}
	}

	
} // end order class