<?php
    class DAOStock{
        private $host="localhost";
	private $dbname="stock";
	private $username="root";
	private $password="";
	private $dbh;

	public function __construct() {
		
	}
	
	public function connection() {
		try {
			$this->dbh = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->password);
			print "Connexion réussie";
		} catch (PDOException $e) {
			print $e->getMessage();
			// tenter de réessayer la connexion après un certain délai, par exemple
			print "Oups ! connexion échouée.";
		}
	}


    }


?>