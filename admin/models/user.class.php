<?php 

/**  
  * @desc Admin related classes and methodes   
  * examples 
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_admin.class
*/  


class user extends db_admin{

	public function login ($password){

//------------------------------------ check if name is not empty
		$msg = "";
		
			if (!empty($password)) {

//------------------------------------ password check

				$hashed_password = SHA1($password);

				$pdostatement = $this->query('SELECT id, password, type FROM user WHERE type="admin";');
				$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

				$true_password = $result['password'];

				if ($hashed_password == $true_password) {
//------------------------------------ login

					session_start();
					
					$_SESSION['user_type'] = "admin";
					//$_SESSION['loggedin'] = TRUE;

					header("location: ?page=orders_management");

				} else { // incorrect password 

					return $msg .=  '<div class="error">le mot de passe: <b>'.$password.'</b> est incorrect.</div>';
				}

			} else { // password is empty

				return $msg .=  "<div class=\"error\">Entrer le mot de passe administrateur pour entrer.</div>";
		
			}
						
		return $msg;

	} // end of login function


	public function logout(){

 		session_start();

		session_destroy();

		header("location: ?page=connexion_admin");

	} // end of logout function
	

	public function edit ($user_id, $type, $company, $name, $address, $city, $zip, $tel, $website, $comment){


		$pdostatement = $this->query('UPDATE user SET type="'.$type.'", company="'.$company.'", name="'.$name.'", address="'.$address.'", city="'.$city.'", zip="'.$zip.'", tel="'.$tel.'", website="'.$website.'", comment="'.$comment.'" WHERE id="'.$user_id.'";');

			if (!$pdostatement) {
			   $msg .= "\nPDO::errorInfo():\n";
			   $msg = print_r($this->errorInfo());
			}


		$msg .= '<div class="valide">Utilisateur mis a jour.</div>';

		return $msg;

	} // end of register function


	public function form ($user_id){

		$pdostatement = $this->query('SELECT * FROM user WHERE id="'.$user_id.'";');

		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$products = implode("|", $result);
		
		return $products;

	} // end of edit function


	public function memberList (){

		$pdostatement = $this->query("SELECT * FROM user ;");
		
		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {

			if ($i['type']=="admin" OR $i['type']=="Open CFAO") {
				$edit = "";
				$delete = "";
			} else {
				$edit = '<a href="?page=users_management&edit_user=1&user_id=' . $i['id'] . '"> 
		    	<button> Editer </button>';

		    	$delete = '<a href="?page=users_management&del=1&user_id=' . $i['id'] . '"> 
		    	<button> X </button>';
			}
			
			$table .= '<tr>';
			$table .= '<td align="center">' . $i['id'] . '</td>';
			$table .= '<td align="left">' . $i['type'] . '</td>';
			$table .= '<td align="left">' . $i['company'] . '</td>';
		    $table .= '<td align="left">' . $i['name'] . '</td>';
		    $table .= '<td align="left">' . $i['address'] . '</td>';
		    $table .= '<td align="left">' . $i['city'] . '</td>';
		    $table .= '<td align="center">' . $i['zip'] . '</td>';
		    $table .= '<td align="left">' . $i['tel'] . '</td>';
		    $table .= '<td align="left">' . $i['email'] . '</td>';
		    $table .= '<td align="left">' . $i['website'] . '</td>';
		    $table .= '<td align="left">' . $i['comment'] . '</td>';
		    $table .= '<td align="center">' . $i['registration_date'] . '</td>';
		    $table .= '<td align="center">' . $i['user_ip'] . '</td>';
		    $table .= '<td align="center">'.$edit.'</td>';
		    $table .= '<td align="center">'.$delete.'</td>';
			$table .= '</tr>';
		} 
		
		return $table;

	} // end of add function


	public function delete ($user_id){

		$pdostatement = $this->query('DELETE FROM user WHERE id = "' . $user_id . '" ;');

	} // end of delete function


	public function nb_user (){

		$pdostatement = $this->query('SELECT COUNT(id) FROM user WHERE type="user" ;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		
		$nb_user = $result['COUNT(id)'];
		
		return $nb_user;

	} // end of abonne function

	
	public function send_newsletter ($expediteur, $sujet, $message){

		if (!empty($expediteur) AND !empty($sujet) AND !empty($message)) {
			
			$pdostatement = $this->query('SELECT m.email FROM membres m, newsletter nl WHERE m.id_membre=nl.id_membre;');
		
			while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
						
				$to = $i['email'];
				$subject = $sujet;
				$message = $message;
				$from = $expediteur;
				$headers = "From: order.cfao.fr";
				mail($to,$subject,$message,$headers);
				
				$msg = '<div class="valide">La newsletter a bien été envoyée</div>';
			}

		} else {
			$msg = '<div class="error">Tout les champs doivent etre remplis</div>';
		}

		return $msg;

	} // end of send_newsletter function


} // end of user class
































