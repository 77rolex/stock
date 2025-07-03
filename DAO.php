<?php
    class DAOStock{
    	private $host="localhost";
		private $dbname="gestion-des-stocks";
		private $username="root";
		private $password="";
		private $dbh;

	public function __construct() {
		
	}
	
	public function connection() {
		try {
			$this->dbh = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->password);
			// print "Connexion réussie";
		} catch (PDOException $e) {
			print $e->getMessage();
			// tenter de réessayer la connexion après un certain délai, par exemple
			print "Oups ! connexion échouée.";
		}
	}

	public function getUsers(){
		$users=$this->dbh->prepare("SELECT user_name FROM users ORDER BY user_name;");
		$users->execute();
		return $users->fetchALL(PDO::FETCH_ASSOC);
	}

	public function checkLogin($username,$password){
		$sql="SELECT * FROM users WHERE user_name=?";
		$stmt=$this->dbh->prepare($sql);
		$stmt->execute([$username]);
		$user=$stmt->fetch(PDO::FETCH_ASSOC);

		if($user&& password_verify($password, $user['pwd'])){
			return $user;
		}else{
			return false;
		}
	}

	public function getPwds(){
		$pwds=$this->dbh->prepare("SELECT pwd FROM users ORDER BY user_name;");
		$pwds->execute();
		return $pwds->fetchALL(PDO::FETCH_ASSOC);
	}

	public function getReserves(){
		$sql= "SELECT reserve_name as reserve, color FROM reserves ORDER BY id_reserve;";
		$getColor = $this->dbh->prepare($sql);
		$getColor->execute();
		return $getColor->fetchAll(PDO::FETCH_ASSOC);
	}



	public function deconnection() {
		$this->dbh=null;
	}
    }
?>