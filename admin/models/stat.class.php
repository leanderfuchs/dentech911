<?php 

/**  
  * @desc Statistiques related classes and methodes   
  * examples 
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required db_admin.class
*/	

class stat extends db_admin{

	public function best_products (){

	$pdostatement = $this->query("SELECT DISTINCT s.id_salle, titre, note FROM salles s, avis ORDER BY note DESC;");
		
	while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
		$table .= '<tr>';
	    $table .= '<td align="center">' . $i['id_salle'] . '</td>';
	    $table .= '<td align="left">' . $i['titre'] . '</td>';
	    $table .= '<td align="center">' . $i['note'] . '</td>';
		$table .= '</tr>';
	} 

	return $table;
		
	} //end bestRated



	public function best_sales (){
	
	$pdostatement = $this->query('SELECT DISTINCT s.id_salle, titre, COUNT(dc.id_commande) AS count FROM details_commandes dc, salles s, produits p WHERE s.id_salle=p.id_salle AND p.id_produit=dc.id_produit GROUP BY s.id_salle ORDER BY count DESC LIMIT 05;');
		
	while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
		$table .= '<tr>';
	    $table .= '<td align="center">' . $i['id_salle'] . '</td>';
	    $table .= '<td align="left">' . $i['titre'] . '</td>';
	    $table .= '<td align="center">' . $i['count'] . '</td>';
		$table .= '</tr>';
	} 

	return $table;
	} //end bestSales



	public function best_clients (){

	$pdostatement = $this->query("SELECT DISTINCT m.id_membre, pseudo, nom, prenom, COUNT(c.id_membre) AS count FROM membres m, commandes c WHERE m.id_membre=c.id_membre GROUP BY m.id_membre ORDER BY count DESC LIMIT 05;");
		
	while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
		$table .= '<tr>';
	    $table .= '<td align="center">' . $i['id_membre'] . '</td>';
	    $table .= '<td align="left">' . $i['pseudo'] . '</td>';
	    $table .= '<td align="left">' . $i['nom'] . '</td>';
	    $table .= '<td align="left">' . $i['prenom'] . '</td>';
	    $table .= '<td align="center">' . $i['count'] . '</td>';
		$table .= '</tr>';
	} 

	return $table;
	} //end bestBuyerQy



	public function sales_quantities (){

	$pdostatement = $this->query("SELECT DISTINCT m.id_membre, pseudo, nom, prenom, SUM( c.montant ) AS count FROM membres m, commandes c WHERE m.id_membre = c.id_membre GROUP BY m.id_membre ORDER BY count DESC LIMIT 05;");
		
	while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
		$table .= '<tr>';
	    $table .= '<td align="center">' . $i['id_membre'] . '</td>';
	    $table .= '<td align="left">' . $i['pseudo'] . '</td>';
	    $table .= '<td align="left">' . $i['nom'] . '</td>';
	    $table .= '<td align="left">' . $i['prenom'] . '</td>';
	    $table .= '<td align="center">' . $i['count'] . ' €</td>';
		$table .= '</tr>';
	} 

	return $table;
	} //end bestBuyer



	public function production_time (){

	$pdostatement = $this->query("SELECT DISTINCT m.id_membre, pseudo, nom, prenom, SUM( c.montant ) AS count FROM membres m, commandes c WHERE m.id_membre = c.id_membre GROUP BY m.id_membre ORDER BY count DESC LIMIT 05;");
		
	while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
		$table .= '<tr>';
	    $table .= '<td align="center">' . $i['id_membre'] . '</td>';
	    $table .= '<td align="left">' . $i['pseudo'] . '</td>';
	    $table .= '<td align="left">' . $i['nom'] . '</td>';
	    $table .= '<td align="left">' . $i['prenom'] . '</td>';
	    $table .= '<td align="center">' . $i['count'] . ' €</td>';
		$table .= '</tr>';
	} 

	return $table;
	} //end bestBuyer

} /*end stat*/




























