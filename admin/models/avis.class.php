<?php 

/**  
  * @desc Avis related classes and methodes    
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_admin.class
*/  


class avis extends db_admin{

	public function view (){

		$pdostatement = $this->query('SELECT * FROM avis;');
		
		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
			$table .= '<tr>';
		    $table .= '<td align="center">' . $i['id_avis'] . '</td>';
		    $table .= '<td align="center">' . $i['id_membre'] . ' € </td>';
		    $table .= '<td align="center">' . $i['id_salle'] . '</td>';
		    $table .= '<td align="left">' . $i['commentaire'] . '</td>';
		    $table .= '<td align="center">' . $i['note'] . '</td>';
		    $table .= '<td align="center">' . $i['date'] . '</td>';
			$table .= '<td align="center"> 
		    	<a href="?page=gestion_avis&del=1&id_avis=' . $i['id_avis'] . '"> 
		    	<button> X </button> 
		    	</td>';			
		    $table .= '</tr>';
		} 

		return $table;

	} // end of add function


	public function delete($id_avis){

		$pdostatement = $this->query('DELETE FROM avis WHERE id_avis = "' . $id_avis . '" ;');

	} // end of delete function


} // end of avis class




















