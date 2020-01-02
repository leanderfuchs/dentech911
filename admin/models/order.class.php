<?php 

/**  
  * @desc Product related classes and methodes    
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_admin.class
*/  


class order extends db_admin{

	public function view (){

		$table = '';
		$supplier = '';

		$pdostatement = $this->query("SELECT DISTINCT name, o.* FROM orders o, user u WHERE o.user_ref_id=u.id ORDER BY id DESC;");
		
		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {

			//------------------------------------ find the supplier name
			
			$find_supplier_name = $this->query('SELECT name FROM user WHERE id='.$i["supplier_ref_id"].';');
			
			if (!empty($find_supplier_name)) {
				$result = $find_supplier_name->fetch(PDO::FETCH_ASSOC);
				$supplier = $result['name'];
			}

			//------------------------------------ ecrir payer ou impaye
			
			if ($i['paiment_status']==1) {
				$i['paiment_status'] = 'Payée';
			} else {
				$i['paiment_status'] = 'Impayée';
			}

			//------------------------------------ Table
			$table .= '<tr>';
			$table .= '<td align="center">' . $i['id'] . '</td>';
			$table .= '<td align="center">' . $supplier . '</td>';
			$table .= '<td align="center">' . $i['arrival_date'] . '</td>';
			$table .= '<td align="left">' . $i['name'] . '</td>';
		    $table .= '<td align="left">' . $i['patient_id'] . '</td>';
		    $table .= '<td align="left">' . $i['status'] . '</td>';
		    $table .= '<td align="center">' . $i['paiment_status'] . '</td>';
		    $table .= '<td align="left">' . $i['teeth_nbr'] . '</td>';
		    $table .= '<td align="left">' . $i['product_name'] . '</td>';
		    $table .= '<td align="center">' . $i['quantity'] . '</td>';
		    $table .= '<td align="center">' . $i['vita_body'] . $i['vita3d_body'] . '</td>';
		    $table .= '<td align="center"><a href="?page=orders_management&edit_order=1&product_id=' . $i['id'] . '"><button>editer</button></td>';
		    $table .= '<td align="center"> 
		    	<a href="?page=orders_management&delete_order=1&product_id=' . $i['id'] . '"> 
		    	<button> X </button> 
		    	</td>';
			$table .= '</tr>';
		} 
		
		return $table;

	} // end of add function


	public function details ($order_id){

		$pdostatement = $this->query('SELECT * FROM orders WHERE id=' . $order_id . ' ;');
		
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$orders = implode("|", $result);
		
		return $orders;

	} // end of delete function

	public function edit ($order_id, $patient_id, $status, $paiment_status, $teeth_nbr, $product_name, $quantity, $vita, $vita3d, $supplier_id){

		//------------------------------------ control du status actuel
		
		$pdostatement = $this->query('SELECT status FROM orders WHERE id="'.$order_id.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$current_status = $result['status'];

		if ($current_status != $status) {

			
		if ($status == "Envoyée") $localization = "Serveurs DenTech911";
		if ($status == "Reçu par le destinataire") $localization = "Prestataire";
		if ($status == "En cours de fabrication") $localization = "Prestataire";
		if ($status == "Livraison") $localization = "Transporteur";
		if ($status == "Reçu par le client") $localization = "Client";

			//------------------------------------ Creer un evenement

			$pdostatement = $this->query('INSERT INTO case_track (case_ref_id, time, localization, status) VALUES ("' . $order_id . '", NOW(), "'.$localization.'" , "'.$status.'");');
		}
		
		$msg = '';
		$pdostatement = $this->query('UPDATE orders SET patient_id="'.$patient_id.'", status="'.$status.'", paiment_status="'.$paiment_status.'", teeth_nbr="'.$teeth_nbr.'", product_name="'.$product_name.'", quantity="'.$quantity.'", vita_body="'.$vita.'", vita3d_body="'.$vita3d.'", supplier_ref_id="'.$supplier_id.'" WHERE id="'.$order_id.'";');

		if (!$pdostatement) {
		   $msg .= "\nPDO::errorInfo():\n";
		   $msg = print_r($this->errorInfo());
		}

		return $msg;

	} // end of edit function

	public function delete ($product_id){

		$pdostatement = $this->query('DELETE FROM orders WHERE id = "' . $product_id . '" ;');

	} // end of delete function


} // end of order class


















