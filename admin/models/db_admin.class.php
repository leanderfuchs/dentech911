<?php 

/**  
  * @desc connection to the database for admin purposes
  * examples $connect = new PDO('mysql:dbname=order.cfao.fr;host=localhost', 'admin', 'admin');
  * @author leander Fuchs leanderfuchs@gmail.com 
  * @required PDO
*/  

class db_admin extends PDO{

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

//------------------------------------ affichage du menu
	public function menu_admin ($user_id){

		$menu = '';

		if ($user_id == 1) {
			
			$pdostatement = $this->query('SELECT title, link FROM page WHERE access_right="admin" AND link_display="menu";');

			while ($i = $pdostatement->fetch(PDO::FETCH_ASSOC)) {
						$menu .= '<a href="?page=' . $i['link'] .'">' . $i['title'] . '</a>';						
			}
		}

		return $menu;

	}

}








