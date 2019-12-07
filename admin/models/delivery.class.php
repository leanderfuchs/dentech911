<?php 

/**  
* @desc    
* examples 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  


class delivery extends db_admin{

	

	public function deliveryList(){

		$pdostatement = $this->query("SELECT * FROM delivery ;");
		
		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {

			$edit = '<a href="?page=delivery_management&edit_delivery=1&delivery_id=' . $i['id'] . '"> 
		    	<button> Editer </button>';
			
			$table .= '<tr>';

			$table .= '<td align="center">' . $i['order_ref_id'] . '</td>';
			$table .= '<td align="center">' . $i['supplier_tracking_nbr'] . '</td>';
		    $table .= '<td align="center">' . $i['open_tracking_nbr'] . '</td>';
		    $table .= '<td align="center">' . $edit . '</td>';
			
			$table .= '</tr>';
		} 
		
		return $table;

	} // end deliveryList function


	public function edit ($delivery_id, $track_supplier, $track_open){


		$pdostatement = $this->query('UPDATE delivery SET supplier_tracking_nbr="'.$track_supplier.'", open_tracking_nbr="'.$track_open.'" WHERE id="'.$delivery_id.'";');

			if (!$pdostatement) {
			   $msg .= "\nPDO::errorInfo():\n";
			   $msg = print_r($this->errorInfo());
			}


		$msg .= '<div class="valide">Numéro de suivi mis a jour.</div>';

		return $msg;

	} // end of edit function


	public function form ($delivery_id){

		$pdostatement = $this->query('SELECT * FROM delivery WHERE id="'.$delivery_id.'";');

		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$delivery_infos = implode("|", $result);
		
		return $delivery_infos;

	} // end of form function

} // end order class


























