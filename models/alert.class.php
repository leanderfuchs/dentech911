<?php 

/**  
* @desc
* examples 
* @author leander Fuchs leanderfuchs@gmail.com 
* @required db_connect.class
*/  


class alert extends db_connect{

	public function missingInfoCaseList(){

		//------------------------------------ trouver le numero de la commande

		$caselist = array();	

		$pdostatement = $this->query('SELECT DISTINCT o.id FROM orders o LEFT JOIN case_track ct ON ct.case_ref_id=o.id WHERE localization = "Centre de Fraisage" AND time <= CURRENT_DATE - INTERVAL "20" DAY AND (lot="" AND ref="" AND tracking="")ORDER BY o.id DESC;');

		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
			$caselist[]=$i; 
		}

		return $caselist;

	} // end missinInfo methode

	public function displayMissingInfoMessage($caselist){
		
		$arrlength=count($caselist);

		$alert .= '<div class="alert">il y a '.$arrlength.' cas dont les informations de suivi sont manquantes.<ul>';
		
		reset($caselist);		

		foreach($caselist as $key=>$value){
			$key+=1;
			$alert .= '<div class="alert_link"><li><a href="'. $_SERVER[SERVER_NAME] .'?page=order_detail&id='. $value[id] .'">Cas #'. $value[id] .' est incomplet. Les champs "Lot#", "Ref#" et "Tracking#" doivent être renseignés.</a></li></div>';
		}
		
		$alert .= '</ul></div>';

		return $alert;

	} // end displayMissingInfoMessage methode


	public function changeSentCasesStatus($user_id){

		//------------------------------------ trouver le numero de la commande

		$caselist = array();

		/*$pdostatement = $this->query('SELECT o.id FROM orders o, user u WHERE o.status = "En cours de livraison" AND u.id="'. $user_id .'" ORDER BY o.id DESC;');*/

		$pdostatement = $this->query('SELECT DISTINCT o.id FROM orders o LEFT JOIN user u ON o.user_ref_id=u.id WHERE o.status = "En cours de livraison" AND u.id="'. $user_id .'" ORDER BY o.id DESC;');

		while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
			$caselist[]=$i; 
		}

		return $caselist;

	} // end missinInfo methode

	public function updateStatusToDelivered($caselist){
		
		$arrlength=count($caselist);

		if ($arrlength==1) {
			$alert .= '<div class="alert">Nous vous avons envoyé un cas, l\'avez vous reçu ?<ul>';
		} else {
			$alert .= '<div class="alert">Nous vous avons envoyé '.$arrlength.' cas, les avez vous reçus ?<ul>';

		}
		
		reset($caselist);		

		foreach($caselist as $key=>$value){
			$key+=1;
			$alert .= '<div class="alert_link"><li><a href="'. $_SERVER[SERVER_NAME] .'/commande/?page=order_detail&id='. $value[id] .'">Si vous avez reçu le cas #'. $value[id] .' veillez cliquer sur ce lien.</a></li></div>';
		}
		
		$alert .= '</ul></div>';

		return $alert;

	} // end displayMissingInfoMessage methode

	
} // end alert class


























