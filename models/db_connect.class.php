<?php
/**
  * @desc connection to the database
  * examples $connect = new PDO('mysql:dbname=order.cfao.fr;host=localhost', 'admin', 'admin');
  * @author leander Fuchs leanderfuchs@gmail.com
  * @required PDO
*/

class db_connect extends PDO{
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

       	} elseif ($_SERVER['SERVER_NAME']=="dentech911.com") {
			$this->engine = 'mysql';
			$this->host = 'fl2yh.myd.infomaniak.com';
			$this->database = 'fl2yh_dentech911';
			$this->user = 'fl2yh_dentech911';
			$this->pass = 'GZT_JPXohZLT'; 
			$dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        	parent::__construct( $dns, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        }else {
        	echo 'Connection avec la base de donnee impossible';
        }
    }
//------------------------------------ affichage du menu 

	public function page_query($page_name, $query){
		$pdostatement = $this->query('SELECT '.$query.' FROM page WHERE link="'.$page_name.'";');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		return $result[$query];
	}

	public function page_menu($link_display){
		$result=[];
		$pdostatement = $this->query('SELECT title, link FROM page WHERE link_display="'.$link_display.'";');
		$pdostatement->execute();
		return $result = $pdostatement->fetchAll();
	}

	public function options_query($query){
		$pdostatement = $this->query('SELECT '.$query.' FROM options;');
		$result = $pdostatement->fetch(PDO::FETCH_ASSOC);
		return $result[$query];
	}
}