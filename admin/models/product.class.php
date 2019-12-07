<?php 

/**  
  * @desc Product related classes and methodes    
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_admin.class
*/  


class product extends db_admin{

	public function add ($name, $price, $processing_time){

		if (empty($name) OR empty($price) OR empty($processing_time)) {
			
			$msg .= '<div class="error">Tous les champs doivent être remplis.</div>';
			
		} else {
			
			$pdostatement = $this->query('INSERT INTO product (name, price, processing_time) VALUES ("'.$name.'", "'.$price.'","'.$processing_time.'");');

			$msg .= '<div class="valide">Le produit à été ajouté avec succes.</div>';

		}
		
		return $msg;

	} // end of add function



	public function watch (){

		$pdostatement = $this->query("SELECT * FROM product;");
		
		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {

			$table .= '<tr>';
			$table .= '<td align="center">' . $i['id'] . '</td>';
			$table .= '<td align="left">' . $i['name'] . '</td>';
		    $table .= '<td align="center">' . $i['processing_time'] . '</td>';
		    $table .= '<td align="right">' . $i['price'] . '</td>';
		    $table .= '<td align="center"><a href="?page=products_management&editform=1&product_id=' . $i['id'] . '
		    	"><button>éditer</button></td>';
		    $table .= '<td align="center"> 
		    	<a href="?page=products_management&del=1&id=' . $i['id'] . '"> 
		    	<button> X </button> 
		    	</td>';
			$table .= '</tr>';
		} 
		
		return $table;

	} // end of add function


	public function delete ($product_id){

		$pdostatement = $this->query('DELETE FROM product WHERE id = "' . $product_id . '" ;');

	} // end of delete function


	public function edit ($product_id, $name, $price, $processing_time){

		//------------------------------------ verification des champs

		if (empty($name) OR empty($price) OR empty($processing_time)) {
			
			$msg .= '<div class="error">Tous les champs doivent etre remplies.</div>';
			
		} else {

			$pdostatement = $this->query('UPDATE product SET name="'.$name.'", price="'.$price.'", processing_time="'.$processing_time.'" WHERE id="'.$product_id.'";');

			if (!$pdostatement) {
			   $msg .= "\nPDO::errorInfo():\n";
			   $msg = print_r($this->errorInfo());
			}

			$msg .= '<div class="valide">Le produit a ete mise a jour avec succes.</div>';

		} 
		
		return $msg;

	} // end of edit function


	public function form ($id_produit){

		$pdostatement = $this->query('SELECT * FROM product WHERE id="'.$id_produit.'";');

		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$products = implode(",", $result);
		
		return $products;

	} // end of edit function

	public function edit_product (){

		$pdostatement = $this->query('SELECT * FROM promotions;');

		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {

			$promos .= '<option value="'.$i['code_promo'].'">'.$i['code_promo'].'</option>';

		}
		
		header("location: ?page=gestion_produits");

		return $promos;

	} // end of edit function


	public function listing(){

		$product_listing = "";
		
		$pdostatement = $this->query("SELECT * FROM product ORDER BY name; ");

		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
			$product_listing .= '<option value="' .$i['name']. '">' .$i['name']. '</option>';
		}				
		
		return $product_listing;
	}
} // end of product class
