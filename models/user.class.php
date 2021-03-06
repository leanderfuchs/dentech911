<?php 

/**  
  * @desc user related classes and methodes   
  * examples 
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_connect.class
*/  


class user extends db_connect{

	public function register ($company, $name, $address, $zip, $city, $tel, $email, $password, $user_ip){

		$msg ='';
//------------------------------------ check if pseudo is not empty
		if(!empty($company) AND !empty($name) AND !empty($address) AND !empty($zip) AND !empty($city) AND !empty($tel) AND !empty($email) AND !empty($password)){
//------------------------------------ check if pseudo is available
			$pdostatement = $this->query('SELECT email FROM user WHERE email="' . $email . '";');
			$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
			if ($email == $result['email']) {	
				$msg = '<div class="alert alert-danger mt-5">Un compte à cette email: "'.$email.'" à déjà été crée</div>';
			}else{
//------------------------------------ check if password is valid
				$check_password = preg_match("/^[a-z0-9_-]{3,40}$/i", $password);
				if ($check_password) {
					$hashed_password = SHA1($password);
//------------------------------------ stip spaces from telephone
					$tel = trim($tel, " ");
//------------------------------------ save new member in DB and welcome message. 
					$pdostatement = $this->query('INSERT INTO user (company, name, address, zip, city, tel, email, password, registration_date, type, user_ip) VALUES ("'.$company.'","'.$name.'","'.$address.'","'.$zip.'","'.$city.'","'.$tel.'","'.$email.'","'.$hashed_password.'", NOW(),"user", "'.$user_ip.'");');

					if (!$pdostatement) {
					   $msg .= "\nPDO::errorInfo():\n";
					   $msg = print_r($this->errorInfo());
					}
//------------------------------------ Send welcome email
					$notification = new notification;
					$notification->register($email, $name);

//------------------------------------ find user ID
					$dbquery = $this->query('SELECT id FROM user ORDER BY ID DESC LIMIT 1;');
					$result_user_id = $dbquery->fetch(PDO::FETCH_ASSOC);
					$user_id = $result_user_id['id'];

//------------------------------------ Create session 

					$session = new session;
					$session->Auth = TRUE;
					$session->user_id = $user_id;
					setcookie('Auth', $user_id . '878544'. SHA1($user_id.$password), time()+3600*24*365);

//------------------------------------ Mot de passe invalide

				} else { // password invalid

					$msg = '<div class="alert alert-danger mt-5">votre mot de passe n\'est pas valide. Vous devez entrer un mot de passe d\'au moins 3 charactere et seul les chiffres, les lettres et les signes (._-) sont autorisés.</div>';
				} //end check password

			 } // valide: pas de compte a cette email deja cree
							
		}else { // il manque un champ

			$msg = '<div class="alert alert-danger mt-5">Tous les champs sont requis</div>';

		}

		return $msg;

	} // end of register function

	public function update ($user_id, $company, $address, $zip, $city, $tel, $email){

//------------------------------------ check if pseudo is not empty

		if(!empty($company) AND !empty($address) AND !empty($zip) AND !empty($city) AND !empty($tel) AND !empty($email)){
							
//------------------------------------ save new member in DB and welcome message. 
			$pdostatement = $this->query("UPDATE user SET company='".$company."', address='".$address."', zip='".$zip."', city='".$city."', tel='".$tel."', email='".$email."' WHERE id='".$user_id."';");
			
			if (!$pdostatement) {
				$msg .= "\nPDO::errorInfo():\n";
				$msg .= '<pre>'.print_r($this->errorInfo()).'</pre>';
			}

			$msg .= '<div class="valide">Votre profil a été mis à jour</div>';
					
		}else{ //if email is empty 

			$msg .= '<div class="error">Vous devez competer tous les champs.</div>';

		} 

		return $msg;

	} // end of register function



	public function login ($email, $password, $remember){
		$error='';
//------------------------------------ Prevent sql injections
		$email = htmlspecialchars($email);
		$password = htmlspecialchars($password);
		$remember = htmlspecialchars($remember);

//------------------------------------ check if pseudo exists
										
		$pdostatement = $this->query('SELECT email FROM user WHERE email="' . $email . '";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		
		if ($email == $result['email']) {

//------------------------------------ password check

			$ashed_password = SHA1($password);

			$pdostatement = $this->query('SELECT id, password, name FROM user WHERE email="' . $email . '";');
			$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

			$name = $result['name'];
			$user_id = $result['id'];
			$password = $result['password'];

			//if ($hashed_password == $result['password']) {
			if ($ashed_password == $password) {
				//------------------------------------ set all direct login infos.
				$session = new session;
				$session->user_id = $user_id;
				$session->Auth = TRUE;
				$this->check_balance($user_id);
				if($remember == 'remember')	{
					setcookie('Auth', $user_id . '878544'. SHA1($user_id.$password), time()+3600*24*365);
				}

			} else { // incorrect password 
				$error = 'Votre mot de passe est incorrect';
			}
		} else { // password is empty
			$error = 'Il y a une erreur dans l\'adresse email '. $email;
		}
		return $error;
	} // end of login function


	public function logout(){
		$session = new Session;
		unset( $_SESSION );
		session_destroy();
		setcookie('Auth', '', time()-1);
		header("location: ?page=login");
		exit();
	} // end of logout function

	public function access($user_id){

		$pdostatement = $this->query('SELECT type FROM user WHERE id="' . $user_id . '";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$access = $result['type'];

		return $access;
		
	} // end of access function
	

	public function type($user_id){

		$pdostatement = $this->query('SELECT type FROM user WHERE id="' . $user_id . '";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$type = $result['type'];

		return $type;
		
	} // end of access function

//------------------------------------ Creer un nouveau mot de passe et l'envoyer par email.


	public function newpasswrd($email){

   		$email = htmlspecialchars($email);

		if (empty($email)) { // Si aucun pseudo est entre

			$msg = '<div class="alert alert-danger">Veuillez entrer votre email</div>';

		} else { // Si l'email est entree

			$pdostatement = $this->query('SELECT * FROM user WHERE email="' . $email . '";');
			$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

			if ($result) { // si existe dans la base de donnee

				//------------------------------------ creation d'un nouveau mot de passe

				$length = 10;
				$newpasswrd = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
				$hashed_newpasswrd = SHA1($newpasswrd);

				//------------------------------------ envoie du nouveau mot de passe.
				$pdostatement = $this->query('UPDATE user SET password = "'.$hashed_newpasswrd.'" WHERE id="' . $result['id'] . '";');

				// SEND EMAIL 

				$to_email = $result['email'];
				$notification = new notification;
				$notification->newpasswrd($to_email, $newpasswrd);

				$msg = '<div class="alert alert-success"> Merci, nous venons de vous envoyer votre nouveau mot de passe dons votre boîte mail. (vérifiez les spams)</div>';

			} else { // si existe pas dans la base

				$msg = '<div class="alert alert-danger mt-5"> Cet email: ' . $email . ' est inconnu. Vérifiez son orthographe</div>';
			}
		}
		return $msg;
	} // end of newpasswrd function

	public function profil ($user_id){

		//------------------------------------ return all infos

		$pdostatement = $this->query('SELECT * FROM user WHERE id="'.$user_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$membre = implode("|", $result);

		return $membre;

	} // end of register function


	public function name ($user_id){

		//------------------------------------ return all infos

		$pdostatement = $this->query('SELECT name FROM user WHERE id="'.$user_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$name = $result['name'];

		return $name;

	} // end of register function



	public function remember_me ($user_id, $cookie_key){

	//------------------------------------ trouver le mot de passe du membre
		$user_id = htmlentities($user_id);
		$cookie_key = htmlentities($cookie_key);

		$pdostatement = $this->query('SELECT * FROM user WHERE id="'.$user_id.'" ;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$password = $result['password'];
		$user_id = $result['id'];

		$key = SHA1($user_id.$password);

		if ($cookie_key === $key) {
			$session = new Session;
			$session->user_id = $user_id;
			$session->Auth = TRUE;
			$session->origin = 'Session Origin=Cookie';
			header('location:?page=order&welcome-back=true');
		}

		return TRUE;
		
	} // end of remember_me function

	public function new_email($email){

		$email = htmlspecialchars($email);
		
		// check if email doesn't exists
		$pdostatement = $this->query('SELECT id FROM user WHERE email="'.$email.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$user_id = $result['id'];

		if($user_id>0){
			return $user_id;
		} else {
			// create a new user password
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$pass = array(); //remember to declare $pass as an array
			$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			for ($i = 0; $i < 15; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			$generated_password = implode($pass); //turn the array into a string
			$hashed_password = SHA1($generated_password);

			//------------------------------------ save new member in DB and welcome message. 
			$pdostatement = $this->query('INSERT INTO user (email, password, registration_date, type) VALUES ("'.$email.'","'.$hashed_password.'", NOW(),"user");');

			if (!$pdostatement) {
			   $msg .= "\nPDO::errorInfo():\n";
			   $msg = print_r($this->errorInfo());
			}

			//------------------------------------ Send welcome email
			$notification = new notification;
			$notification->new_email($email, $generated_password);

			//------------------------------------ find user ID
			$dbquery = $this->query('SELECT id FROM user ORDER BY ID DESC LIMIT 1;');
			$result_user_id = $dbquery->fetch(PDO::FETCH_ASSOC);
			$new_user_id = $result_user_id['id'];

			return $new_user_id;
		}
	}

	public function user_query($user_id, $query) {
		$pdostatement = $this->query('SELECT '.$query.' FROM user WHERE id="'.$user_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$result = $result[$query];
		return $result;
	}

	public function check_balance($user_id){
		$pdostatement = $this->query('SELECT balance FROM user WHERE id='.$user_id.';');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$actual_balance = $result['balance'];

		$session = new session;
		$session->balance = $actual_balance;
		return $actual_balance;
	}

	public function contacts($user_id){
		$contact_list = array();
		$pdostatement = $this->query('SELECT DISTINCT supplier_ref_id FROM orders WHERE user_ref_id = '.$user_id.';');
		$contact_ids = $pdostatement->fetchAll(PDO::FETCH_ASSOC);
		if (!empty($contact_ids)){
			foreach($contact_ids as $contact){
				$pdostatement = $this->query('SELECT id, email, name, company FROM user WHERE id='.$contact['supplier_ref_id'].';');
				$contact_list[] = $pdostatement->fetch(PDO::FETCH_ASSOC);
			}
		}
		return $contact_list;
	}

	public function add_points($user_id, $points) {
		$pdostatement = $this->query('UPDATE user SET balance = balance + '.$points.' WHERE id='.$user_id.';');	
	}

	public function remove_points($user_id, $points) {
		$pdostatement = $this->query('UPDATE user SET balance = balance - '.$points.' WHERE id='.$user_id.';');	
	}

	public function send_points($user_id, $points, $email){
		//find recipient id with email or FALSE
		$pdostatement = $this->query('SELECT id FROM user WHERE email="'.$email.'";');
		$recipients = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$recipient_id = $recipients['id'];

		//Check result
		if (empty($recipient_id)){
			return FALSE;
		} else {
		// If email fund, add / remove points
			$this->add_points($recipient_id, $points);
			$this->remove_points($user_id, $points);
			return TRUE;
		}
	}

	public function ads_source($source){
		$msg = '';
		$source = htmlentities($source);
		
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$user_agent = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $user_agent );
		$user_agent = str_replace(array('[\', \']'), '', $user_agent);
		$user_agent = preg_replace('/\[.*\]/U', '', $user_agent);
		$user_agent = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $user_agent);
		$user_agent = htmlentities($user_agent, ENT_COMPAT, 'utf-8');
		$user_agent = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $user_agent );
		$user_agent = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $user_agent);

		$user_ip = $_SERVER['REMOTE_ADDR'];
		$pdostatement = $this->query('INSERT INTO visitor (user_agent, user_ip, user_source, date_time) VALUES ("'.$user_agent.'", "'.$user_ip.'", "'.$source.'", NOW());');
		
		if (!$pdostatement) {
			$msg .= "\nPDO::errorInfo():\n";
			$msg .= print_r($this->errorInfo());
		}
		return $msg;
	}
} // end of user class