<?php 
class ConvertMonthName{

	public function shortnames ($monthname){

		$english_month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$french_month = array('jan', 'fev', 'mar', 'avr', 'mai', 'juin', 'juil', 'aout', 'sep', 'oct', 'nov', 'déc');
		
		$monthname = str_replace($english_month, $french_month, $monthname);

		return $monthname;

	}


	public function longnames ($monthname){

		$english_month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$french_month = array('janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'décembre');
		
		$monthname = str_replace($english_month, $french_month, $monthname);

		return $monthname;

	}
}

//------------------------------------ Connection obligatoire a la base de donnee

class search extends PDO{

//------------------------------------ connection base de donnee
    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;
   
     public function __construct(){

		if ($_SERVER['SERVER_NAME']=="192.168.33.10") {
			$this->engine = 'mysql';
			$this->host = 'localhost';
			$this->database = 'open_cfao_order';
			$this->user = 'root';
			$this->pass = 'root'; 
			$dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        	parent::__construct( $dns, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

       	} elseif ($_SERVER['SERVER_NAME']=="commande.opencfao.fr") {
			$this->engine = 'mysql';
			$this->host = 'localhost';
			$this->database = 'opencfao_orders';
			$this->user = 'opencfao';
			$this->pass = 'N2Sg8vUgOCseX56i'; 
			$dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        	parent::__construct( $dns, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        } elseif ($_SERVER['SERVER_NAME']=="www.opencfao.fr") {
			$this->engine = 'mysql';
			$this->host = 'localhost';
			$this->database = 'opencfao_orders';
			$this->user = 'opencfao';
			$this->pass = 'N2Sg8vUgOCseX56i'; 
			$dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        	parent::__construct( $dns, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        }else {
        	echo 'Connection avec la base de donnee impossible';
        }
    }
	//------------------------------------ Demande a la base de donnee securise
	
	public function dbquery($from, $to, $query, $user_id){

		$Convert_Dates = new ConvertMonthName;

		//------------------------------------ secutity

		$from = htmlspecialchars($from); 
		$to = htmlspecialchars($to); 
		$query = htmlspecialchars($query); 

		$sql = "SELECT DISTINCT u.name, o.*  FROM orders o LEFT JOIN user u ON o.user_ref_id=u.id WHERE o.user_ref_id='" . $user_id . "' AND (arrival_date >= '".$from."' AND DATE(arrival_date) <= '".$to."') AND (o.id='".$query."' OR o.patient_id LIKE'%".$query."%' OR o.lot='".$query."' OR o.ref='".$query."' OR o.tracking='".$query."' OR o.product_name LIKE '%".$query."%' OR o.status LIKE '%".$query."%' OR o.vita_body LIKE '%".$query."%' OR o.vita3d_body LIKE '%".$query."%' )ORDER BY id DESC;";

		$output = '<table class="table-striped font-90 centered" border=0>';	
		$output .= '<tr>';
		
		$result = $this->query($sql);
		$rowcount = $result->rowCount();
		if ($rowcount == 0) {
			$output .= '<span class=""><i>Nous n\'avons pas de commande(s) correspondant a cette requete</i></span><br/><br/>';
		} elseif($rowcount == 1){
			$output .= '<span class=""><i>Nous avons trouvé 1 commande correspondant a cette requete</i></span><br/><br/>';
		}else {
			$output .= '<span class=""><i>Nous avons trouvé '. $rowcount .' commandes correspondant a cette requete</i></span><br/><br/>';
		}

		$order_list = $this->query($sql);
		foreach ($order_list as $order_details) {		
			
			switch ($order_details['status']) {
				case "Commande envoyée":
				$color = 'style="color:#0b7215;"';
				break;
				case "Reçu chez Open CFAO":
				$color = 'style="color:#1cb236;"';
				break;
				case "Envoyée en production":
				$color = 'style="color:#1eec41;"';
				break;
				case "En cours de production":
				$color = 'style="color:#f6bb1c;"';
				break;
				case "En retour de production":
				$color = 'style="color:#fc852a;"';
				break;
				case "Prète à être livrée":
				$color = 'style="color:#fb0015;"';
				break;
				case "En cours de livraison":
				$color = 'style="color:#98000d;"';
				break;
				case "Livrée":
				$color = 'style="color:#7f7f7f;"';
				break;
			}
			$output .= '<td width="3%">[' . $order_details['id'] . ']</td>';
			$output .= '<td width="3%">' . date("d/m/Y", strtotime($order_details["arrival_date"])). '</td>';
			$output .= '<td width="17%">' . ucwords($order_details['patient_id']) . '</td>';
			$output .= '<td width="13%">' . $order_details['teeth_nbr'] . '</td>';
			$output .= '<td width="15%">' . $order_details['product_name'] . '</td>';
			$output .= '<td width="3%">' . $order_details['vita_body']. $order_details['vita3d_body'] . '</td>';
			$output .= '<td width="12%" '.$color.'><b>' . $order_details['status'] . '</b></td>';
			$output .= '<td width="5%"> <a href="?page=order_detail&id='.$order_details['id'].'">Détails</a></td>';
		$output .= '</tr>';
		}
		$output .= '</table>';
		return $output;
	}
}

//------------------------------------ Start Session

session_start();

//------------------------------------ load classes

$search = new search;

//------------------------------------ encapsulation des informations du POST
$from = $_POST['from'];
$to = $_POST['to'];
$query = $_POST['query'];

//------------------------------------ user id

$user_id = $_SESSION['user_id'];

//------------------------------------ Gestion des dates
if (empty($from)) {
	$from = '2019-01-01';
} 

if (empty($to)) {
	$to = date('Y-m-d', time()+3600*24*10);
	$today = 'aujourd\'hui';
} else {
	$today = $to;
}

echo '<div class="valide">Requete: '.$query.' entre '.$from.' et '.$today.'</div>';

// display results
$search_dbquery = $search->dbquery($from, $to, $query, $user_id);

echo $search_dbquery;