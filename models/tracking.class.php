<?php

/**  
* @desc    
* examples 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  


class tracking extends db_connect{

public function caselist($user_id){

		$pdostatement = $this->query('SELECT * FROM orders WHERE user_ref_id='.$user_id.' AND status!="Prète à être livrée" AND status!="En cours de livraison" AND status!="Livrée" ORDER BY id DESC;');
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

			if (strpos($key, "lot") !== false) {$lot=$value; 
				
				$pdostatement = $this->query('SELECT id FROM orders WHERE id='.$order_id.' AND lot="'.$lot.'";');
				$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
			
				if (empty($result['id'])) { $this->query('UPDATE orders SET lot="'.$lot.'" WHERE id="'.$order_id.'";');
					$msg .= 'lot updated';
				}
			}

			if (strpos($key, "ref") !== false) {$ref=$value;
				
				$pdostatement = $this->query('SELECT id FROM orders WHERE id='.$order_id.' AND ref="'.$ref.'";');
			
				$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

				if (empty($result['id'])) { $this->query('UPDATE orders SET ref="'.$ref.'" WHERE id="'.$order_id.'";');
					$msg .= 'ref updated';
				}
			}

			if (strpos($key, "tra") !== false) {$tra=$value;
				
				$pdostatement = $this->query('SELECT id FROM orders WHERE id='.$order_id.' AND tracking="'.$tra.'";');
				$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

				if (empty($result['id'])) { $this->query('UPDATE orders SET tracking="'.$tra.'" WHERE id="'.$order_id.'";');
					$msg .= 'tracking updated';
				}
			}

			//$result .= '<br/>lot:'.$lot.' - ref:'.$ref.' - tra:'.$tra.' - order ID:'.$order_id

		}

		$msg .= '<div class="valide">Mise à jours réussi.</div>';

		return $msg;

	} // end of edit function




	public function qrlist(){

		$Convert_Dates = new Convert_Dates;

		$output = '';
		//------------------------------------ retourner un tableau des dernieres commandes

			
		$dates = 'SELECT DISTINCT DATE(arrival_date) AS arrival_date FROM orders  WHERE status!="Prète à être livrée" AND status!="En cours de livraison" AND status!="Livrée" ORDER BY arrival_date DESC;';
		
		foreach ($this->query($dates) as $arrival_date) {

			$output .= '<span class="day-header">'. $Convert_Dates->longnames(date("l d F Y", strtotime($arrival_date["arrival_date"]))) .'</span><br/>';

			$orders = 'SELECT DISTINCT u.name, o.* FROM orders o, user u WHERE DATE(o.arrival_date)="' . $arrival_date['arrival_date'].'" AND u.id=o.user_ref_id AND o.status!="Prète à être livrée" AND o.status!="En cours de livraison" AND o.status!="Livrée" ORDER BY o.id DESC;';

			$output .= '<table class="table-striped font-90 centered" border=0>';	
			$output .= '<tr>';

			foreach ($this->query($orders) as $order_details) {
								
				$output .= '<td width="55px">[' . $order_details['id'] . ']</td>';
				
				$output .= '<td width="170px"><b>' . $order_details['name'] . '</b></td>';
				
				$output .= '<td width="170px">' . ucwords($order_details['patient_id']) . '</td>';

				$ex3 = new QRGenerator(''. $_SERVER['SERVER_NAME'] .'/?page=order_qrcodes&id='.$order_details['id'].'&open=received',200,'ISO-8859-1'); 
				$output .= '<td><img src='.$ex3->generate().'></td>';

				$output .= '<td>' . $order_details['status'] . '</td>';
				
				$output .= '</tr>';
			}

			$output .= '</table>';	
		}
		
		return $output;

	} // end last_orders function


	public function open_received_status ($order_id){

				//------------------------------------ Trouver le status actuelle

		$pdostatement = $this->query('SELECT status FROM orders WHERE id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$current_status = $result['status'];

				//------------------------------------ Verification du status actuel

		if (!empty($current_status) AND ($current_status !== "Prète à être livrée" OR $current_status !== "En cours de livraison" OR $current_status !== "Livrée")) {
				
					//------------------------------------ Mise a jour du status

			$pdostatement = $this->query('UPDATE orders SET status = "Prète à être livrée" WHERE id="' . $order_id . '";');
			
			$msg .= '<div class="valide"> Le status du cas [<b>' . $order_id . '</b>] a été changé pour "<b>Prète à être livrée</b>"</div>';
			
					//------------------------------------ Creer un evenement
			$pdostatement = $this->query('INSERT INTO case_track (case_ref_id, username, time, localization, status) VALUES ("' . $order_id . '", "DenTech911", NOW(), "DenTech911", "Prète à être livrée");');
			
		}

		return $msg;

	} // end add function

}














