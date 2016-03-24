<?php

Class Barang {
	
	public function __construct(){
		$this->db = $this->getDB();
	}

	// Connect Database
	private function getDB() {
		$dbhost="localhost";
		$dbuser="root";
		$dbpass="root";
		$dbname="db_rest";

		$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass); 
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbConnection;
	}

	public function getAllBarang(){
        $sql = "SELECT * FROM barang ORDER BY namaBarang ASC";
        $stmt = $this->db->query($sql); 
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
	}

	public function getBarang($idBarang){
        $sql = "SELECT * FROM barang WHERE idBarang=?";
        $stmt = $this->db->prepare($sql); 
        $stmt->execute(array($idBarang));
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
	}

	public function insertBarang($namaBarang, $kategori, $stok, $hargaBeli, $hargaJual){
        $sql = "INSERT INTO barang (namaBarang, kategori, stok, hargaBeli, hargaJual) VALUES (?,?,?,?,?)";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($namaBarang, $kategori, $stok, $hargaBeli, $hargaJual));
        return $status;
	}

	public function updateBarang($idBarang, $namaBarang, $kategori, $stok, $hargaBeli, $hargaJual){
        $sql = "UPDATE barang SET namaBarang=?, kategori=?, stok=?, hargaBeli=?, hargaJual=? WHERE idBarang=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($namaBarang, $kategori, $stok, $hargaBeli, $hargaJual, $idBarang));
        return $status;
	}

	public function deleteBarang($idBarang){
        $sql = "DELETE FROM barang WHERE idBarang=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($idBarang));
        return $status;
	}
}
?>