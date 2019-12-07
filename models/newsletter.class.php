<?php 

/**  
  * @desc    
  * examples 
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_connect.class
*/  


class newsletter extends db_connect{

	public function newmember($username){
		
		//------------------------------------ trouver l'ID du membre

		$pdostatement = $this->query('SELECT id_membre FROM membres WHERE pseudo = "' . $username . '";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$member_id = $result['id_membre'];

		//------------------------------------ check if member already get newsletters

		$pdostatement = $this->query('SELECT id_membre FROM newsletter WHERE id_membre = "' . $member_id . '";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		if ($result['id_membre']==NULL) {
			
			$pdostatement = $this->query('INSERT INTO newsletter VALUES (NULL, ' . $member_id . ');');

			$msg .= '<div class="valide"> Merci <b>' . $username . '</b>, vous allez recevoir notre mensuelle d\'information dans votre boite mail.</div>';

		} else {

			$msg .= '<div class="error">Vous etes déjà abonné(e) à notre newsletter.</div>';
		}
		

		//------------------------------------ ajouter le membre a la newsletter
	

		
		return $msg;

	}

}