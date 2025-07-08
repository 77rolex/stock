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
		} catch (PDOException $e) {
			print $e->getMessage();
			print "Oups ! connexion échouée.";
		}
	}

	// connection.php
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

	// recupere la valeur saisie dans searchbar ou affiche vide
	public function getSearchbar() {
		 $search = $_GET['search'] ?? "";

	// affiche seulement depuis searchbar
		$search_query = ("SELECT nom_produit, unite, qt, r.color, reserve_name, nom_category
								FROM produits p
								JOIN category c ON c.id_category = p.category_id
								JOIN reserves r ON r.id_reserve = p.reserve_id
								
								");
				if(!empty($search)){  // si $search n'est pas vide execute la condition WHERE ci_dessous
					$search_query .= "WHERE p.nom_produit LIKE :search OR p.id_produit LIKE :search";
					$stmt = $this -> dbh -> prepare($search_query);
					$stmt->execute(['search' => "%$search%"]); // %$search% qui contient le mot dans search
				}
				else {
					$stmt = $this -> dbh -> prepare($search_query);
					$stmt->execute(); // affiche tous les produits	
				}
		return $stmt->fetchAll();
		
	}

	// verifie et affiche l'alerte de seuil

	public function getBelowSeuil($seuil = null) {
		if($seuil === null || is_numeric($seuil)){
			return [];
		}
		$search_query = ("SELECT nom_produit, unite, qt, r.color, reserve_name, nom_category
								FROM produits p
								JOIN category c ON c.id_category = p.category_id
								JOIN reserves r ON r.id_reserve = p.reserve_id
								WHERE p.qt <= :seuil");
<<<<<<< HEAD
				
=======
				// seuil defini && est un number si conditions is true = $seuil
				if($seuil !== null && is_numeric($seuil)){
					
>>>>>>> 68b8a5593972e5227bc4c3415e41791aaffed6d9
					$stmt = $this -> dbh -> prepare($search_query);
					$stmt->execute(["seuil" => $seuil]); // below qty execute
				
		return $stmt->fetchAll();
		}

	//popUp.php
	public function getListOfProducts(){
		$listOfProducts=$this->dbh->prepare("SELECT nom_produit, id_produit FROM produits ORDER BY nom_produit ASC;");
		$listOfProducts->execute();
		return $listOfProducts->fetchAll(PDO::FETCH_ASSOC);
	}
	//popUp.php
	public function getProductsBelowSeuil($seuil) {
    $stmt = $this->dbh->prepare("SELECT * FROM produits WHERE qt <= :seuil");
    $stmt->bindParam(":seuil", $seuil, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
	}
	//cart.php
	public function getProductById($id){
		$productById=$this->dbh->prepare("SELECT * FROM produits WHERE id_produit = ?");
		$productById->execute([$id]);
		return $productById->fetch(PDO::FETCH_ASSOC);
	}
	
	public function getFilteredProducts($search, $seuil) {
		$query = "SELECT nom_produit, id_produit, qt FROM produits WHERE 1=1";
		$params = [];

		if (!empty($search)) {
			$query .= " AND nom_produit LIKE :search";
			$params['search'] = "%$search%";
		}

		if (is_numeric($seuil)) {
			$query .= " AND qt <= :seuil";
			$params['seuil'] = $seuil;
		}

		$stmt = $this->dbh->prepare($query);
		$stmt->execute($params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function logout() {
		session_unset();     
		session_destroy();      
		exit();
	}

	public function deconnection() {
		$this->dbh=null;
	}
    }
?>