<?php 
/**  
  * @desc    
  * examples 
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_connect.class
*/  

class product extends db_connect{
	public function list(){
		$product_list = array();
		$pdostatement = $this->query('SELECT * FROM product;');
		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
			$product_list[]=$i; 
		}
		return $product_list;
	}
}