<?php


class Stats {
	
	/* Configuration */
	
	public $table_name = 'stats';
	
	
	
	/* End of Configuration */
	
	public function __construct($host, $username, $password, $database, $page){
		$this->connect($host, $username, $password, $database);
		if(!$this->checkTable()) $this->createTable();
		$this->page = $page;
	}
	
	public function cue(){
		$time = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$result = $this->query("INSERT INTO `".$this->table_name."` (`time`,`ip`,`page`) VALUES (".$time.", '".$ip."', '".$this->page."')");
		
		if(!$result) throw new Exception('Error: Couldn\'t insert new data in table!');
	}
	
	public function load(){
		
		/* total_hits */
			$result_total_hits = $this->query("SELECT COUNT(*) FROM `".$this->table_name."`");
			$array_total_hits = mysql_fetch_array($result_total_hits);
			$this->total_hits = $array_total_hits[0];
		
		/* total_visitors */
			$result_total_visitors = $this->query("SELECT * FROM `".$this->table_name."` GROUP BY `ip`");
			$this->total_visitors = mysql_num_rows($result_total_visitors);
			
		/* page_hits */
			$result_page_hits = $this->query("SELECT COUNT(*) FROM `".$this->table_name."` WHERE `page` = '".$this->page."'");
			$array_page_hits = mysql_fetch_array($result_page_hits);
			$this->page_hits = $array_page_hits[0];
		
		/* page_visitors */
			$result_page_visitors = $this->query("SELECT * FROM `".$this->table_name."` WHERE `page` = '".$this->page."' GROUP BY `ip`");
			$this->page_visitors = mysql_num_rows($result_page_visitors);
		
		/* ip_hits */
			$result_ip_hits = $this->query("SELECT COUNT(*) FROM `".$this->table_name."` WHERE `ip` = '".$_SERVER['REMOTE_ADDR']."'");
			$array_ip_hits = mysql_fetch_array($result_ip_hits);
			$this->ip_hits = $array_ip_hits[0];
		
		/* ip_page_hits */
			$result_ip_page_hits = $this->query("SELECT COUNt(*) FROM `".$this->table_name."` WHERE `ip` = '".$_SERVER['REMOTE_ADDR']."' AND `page` = '".$this->page."'");
			$array_ip_page_hits = mysql_fetch_array($result_ip_page_hits);
			$this->ip_page_hits = $array_ip_page_hits[0];
		
	}
	
	
	
	/**
	 * MySQL Funktionen
	 */
	
	private function connect($host, $username, $password, $database){
		$this->connection = mysql_connect($host, $username, $password);
		if(!$this->connection) throw new Exception('Error: MySQL Connection failed!');
		
		$this->database = mysql_select_db($database);
		if(!$this->database) throw new Exception('Error: MySQL Database not found!');
	}
	
	private function checkTable(){
		$result = $this->query("SHOW TABLES LIKE '".$this->table_name."'");
		if(mysql_num_rows($result)!=0) return true;
		else return false;
	}
	
	private function createTable(){
		$result = $this->query('CREATE TABLE `'.$this->table_name.'` (`id` INT( 100 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,`time` INT( 100 ) NOT NULL ,`ip` VARCHAR( 100 ) NOT NULL ,`page` VARCHAR( 100 ) NOT NULL)');
		if(!$result) throw new Exception('Error: Failed to create table!');
	}
	
	private function query($query){
		return mysql_query($query);
	}
}














?>