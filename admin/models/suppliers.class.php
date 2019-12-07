<?php 

/**  
  * @desc Admin related classes and methodes   
  * examples 
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_admin.class
*/  


class suppliers extends db_admin{
	

	public function edit ($user_id, $company, $name, $address, $city, $zip, $tel, $website, $comment){


		$pdostatement = $this->query('UPDATE user SET company="'.$company.'", name="'.$name.'", address="'.$address.'", city="'.$city.'", zip="'.$zip.'", tel="'.$tel.'", website="'.$website.'", comment="'.$comment.'" WHERE id="'.$user_id.'";');

			if (!$pdostatement) {
			   $msg .= "\nPDO::errorInfo():\n";
			   $msg = print_r($this->errorInfo());
			}


		$msg .= '<div class="valide">Information(s) mis a jour.</div>';

		return $msg;

	} // end of register function


	public function form ($user_id){

		$pdostatement = $this->query('SELECT * FROM user WHERE id="'.$user_id.'";');

		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$users = implode("|", $result);
		
		return $users;

	} // end of edit function


	public function details ($order_id){

		$pdostatement = $this->query('SELECT user.id, user.name FROM orders, user WHERE orders.id='.$order_id.' AND supplier_ref_id=user.id;');

		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$suppliers = implode("|", $result);
		
		return $suppliers;

	} // end of edit function


	public function name_supplier_list ($order_id){

		//------------------------------------ find the supplier user id
		$name_supplier_list = '';
		
		$pdostatement = $this->query('SELECT user.id FROM orders, user WHERE orders.id='.$order_id.' AND supplier_ref_id=user.id;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		$supplier_id = $result['id'];

		//------------------------------------ Fetch the supplier's list
		
		$pdostatement = $this->query("SELECT id, name FROM user WHERE type='Fournisseur';");

		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
			if ($i['id']==$supplier_id) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$supplier_id = $i['id'];
			$supplier_name = $i['name'];

			$name_supplier_list .= '<option value="'.$supplier_id.'" '.$selected.' >'.$supplier_name.'</option>';
		}
		
		return $name_supplier_list;

	} // end of edit function


	public function memberList (){

		$pdostatement = $this->query("SELECT * FROM user WHERE type='Fournisseur';");
		
		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {

			$edit = '<a href="?page=users_management&edit_user=1&user_id=' . $i['id'] . '"> 
		    	<button> Editer </button>';

		    $delete = '<a href="?page=users_management&del=1&user_id=' . $i['id'] . '"> 
		    	<button> X </button>';
			
			$table .= '<tr>';
			$table .= '<td align="center">' . $i['id'] . '</td>';
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


	public function nb_suppliers (){

		$pdostatement = $this->query('SELECT COUNT(id) FROM user WHERE type="Fournisseur" ;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		
		$nb_suppliers = $result['COUNT(id)'];
		
		return $nb_suppliers;

	} // end of abonne function


} // end of suppliers class
































