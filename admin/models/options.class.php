<?php 

/**  
  * @desc Product related classes and methodes    
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_admin.class
*/  


class options extends db_admin{


	public function edit2 ($site_name, $slogan){

		$pdostatement = $this->query('UPDATE options SET site_name="'.$site_name.'", slogan="'.$slogan.'" WHERE id=1;');

			if (!$pdostatement) {
			   $msg .= "\nPDO::errorInfo():\n";
			   $msg = print_r($this->errorInfo());
			}


		$msg2 .= '<div class="valide">Préférences mis a jour.</div>';

		return $msg2;

	} // end of edit function

	public function edit ($site_name, $slogan){

		//------------------------------------ verification des champs

		if (empty($site_name) OR empty($slogan)) {
			
			$msg = '<div class="error">Tous les champs doivent etre remplies.</div>';
			
		} else {

			$pdostatement = $this->query('UPDATE options SET site_name="'.$site_name.'", slogan="'.$slogan.'" WHERE id="1";');

			if (!$pdostatement) {
			   $msg .= "\nPDO::errorInfo():\n";
			   $msg = print_r($this->errorInfo());
			}

			$msg = '<div class="valide">Préférences mises a jour avec succes.</div>';

		} 
		
		return $msg;

	} // end of edit function



	public function form (){

		$pdostatement = $this->query("SELECT * FROM options;");

		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);

		$options = implode("|", $result);
		
		return $options;

	} // end of edit function




} // end of order class


















