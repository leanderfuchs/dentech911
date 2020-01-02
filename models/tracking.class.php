<?php

/**  
* @desc    
* examples 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  


class tracking extends db_connect{

	public function caselist($user_id){

			$pdostatement = $this->query('SELECT * FROM orders WHERE (user_ref_id='.$user_id.' OR supplier_ref_id='.$user_id.') ORDER BY id DESC;');
			$pdostatement->execute();
			return $pdostatement->fetchAll();
	} // end last_orders function

	public function edit ($all_products){

		$msg = '';
		foreach ($all_products as $key => $value) {

			$lot='';
			$ref='';
			$tra='';

			$details = explode('-', $key);
			$order_id = $details['1'];

			//$result .= '<br/>'.$order_id.' '.$value;

			if (strpos($key, "lot") !== false) {
				$lot=$value; 
				$pdostatement = $this->query('SELECT id FROM orders WHERE id='.$order_id.' AND lot="'.$lot.'";');
				$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
			
				if (empty($result['id'])) { $this->query('UPDATE orders SET lot="'.$lot.'" WHERE id="'.$order_id.'";');
					$msg .= 'lot updated';
				}
			}

			if (strpos($key, "ref") !== false) {
				$ref=$value;
				$pdostatement = $this->query('SELECT id FROM orders WHERE id='.$order_id.' AND ref="'.$ref.'";');
			
				$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

				if (empty($result['id'])) { $this->query('UPDATE orders SET ref="'.$ref.'" WHERE id="'.$order_id.'";');
					$msg .= 'ref updated';
				}
			}

			if (strpos($key, "tra") !== false) {
				$tra=$value;
				$pdostatement = $this->query('SELECT id FROM orders WHERE id='.$order_id.' AND tracking="'.$tra.'";');
				$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

				if (empty($result['id'])) { $this->query('UPDATE orders SET tracking="'.$tra.'" WHERE id="'.$order_id.'";');
					$msg .= 'tracking updated';
				}
			}
		}

		$msg .= '<div class="valide">Mise à jours réussi.</div>';

		return $msg;

	} // end of edit function

	public function qr_update_status ($order_id){

				//------------------------------------ Trouver le status actuelle

		$pdostatement = $this->query('SELECT status FROM case_track WHERE case_ref_id="'.$order_id.'" ORDER BY id DESC LIMIT 1;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$current_status = $result['status'];

		//------------------------------------ Update current status
		switch ($current_status) {
			case "Envoyée":
				$new_status = "Reçu par le destinataire";
				$localisation = "Prestataire";
				break;
			case "Reçu par le destinataire":
				$new_status = "En cours de fabrication";
				$localisation = "Prestataire";
				break;
			case "En cours de fabrication":
				$new_status = "Livraison";
				$localisation = "Transporteur";
				break;
			case "Livraison":
				$new_status = "Reçu par le client";
				$localisation = "Client";
				break;
			case "Reçu par le client":
				$new_status = FALSE;
				break;
		}


		if ($new_status == FALSE) {
			return ;
		} else {

			//------------------------------------ Creer un evenement
			$pdostatement = $this->query('INSERT INTO case_track (case_ref_id, time, localization, status) VALUES ("' . $order_id . '", NOW(), "'.$localisation.'", "' .$new_status. '");');
		}
	} // end add function

	public function track ($order_id){

		$pdostatement = $this->query('SELECT * FROM case_track WHERE case_ref_id=' . $order_id . ';');
		$pdostatement->execute();
		return $pdostatement->fetchAll();

	} // end add function



	public function traceability($order_id, $lot, $ref, $tracking){

		$order_id = htmlspecialchars($order_id);
		$lot = htmlspecialchars($lot);
		$ref = htmlspecialchars($ref);
		$tracking = htmlspecialchars($tracking);

		//------------------------------------ Mise a jour de la tracabilite
		
		$pdostatement = $this->query('UPDATE orders SET lot="'.$lot.'", ref="'.$ref.'" WHERE id="'.$order_id.'";');

		//------------------------------------ Creer un evenement

		$pdostatement = $this->query('INSERT INTO case_track (case_ref_id, time, localization, status) VALUES ("' . $order_id . '", NOW(), "Transporteur", "En retour de production");');

		return TRUE;

	} // end details_commande function

}














