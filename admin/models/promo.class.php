<?php 

/**  
  * @desc Avis related classes and methodes    
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_admin.class
*/  


class promo extends db_admin{

	public function add($code_promo, $reduc){

		if (empty($code_promo) OR empty($reduc)) {
			
			$msg .= '<div class="error">Entrez le code promo et la reduction.</div>';
			
		} else {
			
			$pdostatement = $this->query('INSERT INTO promotions (code_promo, reduction) VALUES ("'.$code_promo.'","'.$reduc.'");');

			$msg .= '<div class="valide">Code promo ajouté.</div>';

		}
		
		return $msg;

	} // end of add function



	public function view (){

		$pdostatement = $this->query('SELECT * FROM promotions;');
		
		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
			$table .= '<tr>';
		    $table .= '<td align="center">' . $i['id_promotion'] . '</td>';
		    $table .= '<td align="center">' . $i['code_promo'] . '</td>';
		    $table .= '<td align="center">' . $i['reduction'] . ' €</td>';
			$table .= '<td align="center"> 
		    	<a href="?page=gestion_promos&watch=1&del=1&id_promo=' . $i['id_promotion'] . '"> 
		    	<button> X </button> 
		    	</td>';			
		    $table .= '</tr>';
		} 

		return $table;

	} // end of add function


	public function delete($id_promo){

		$pdostatement = $this->query('DELETE FROM promotions WHERE id_promotion = "' . $id_promo . '" ;');

	} // end of delete function


} // end of promo class




















