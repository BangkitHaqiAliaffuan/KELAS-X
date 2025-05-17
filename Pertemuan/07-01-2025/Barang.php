<?php
include_once 'koneksi.php';

class Barang {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($nama_barang, $harga, $stok, $gambar) {
        // Menentukan direktori untuk menyimpan gambar
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($gambar["name"]);
        
        // Memindahkan file yang di-upload ke direktori target
        if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
            // Jika berhasil memindahkan file, lakukan insert ke database
            $query = "INSERT INTO barang (nama_barang, harga, stok, gambar) VALUES (:nama_barang, :harga, :stok, :gambar)";
            $stmt = $this->conn->prepare($query);
    
            // Bind parameters
            $stmt->bindParam(':nama_barang', $nama_barang);
            $stmt->bindParam(':harga', $harga);
            $stmt->bindParam(':stok', $stok);
            $stmt->bindParam(':gambar', $target_file); // Simpan path gambar
    
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }
    
    public function read() {
        $query = "SELECT * FROM barang";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update($id, $nama_barang, $harga, $stok, $gambar) {
        // Pertama, ambil gambar saat ini dari database
        $query = "SELECT gambar FROM barang WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Ambil gambar saat ini
        $current_image = $stmt->fetchColumn();
    
        // Jika gambar baru di-upload
        if ($gambar['error'] == UPLOAD_ERR_OK) {
            // Menentukan direktori untuk menyimpan gambar
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($gambar["name"]);
            
            // Memindahkan file yang di-upload ke direktori target
            if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
                // Update dengan gambar baru
                $query = "UPDATE barang SET nama_barang=:nama_barang, harga=:harga, stok=:stok, gambar=:gambar WHERE id=:id";
                $stmt = $this->conn->prepare($query);
                // Bind parameters
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nama_barang', $nama_barang);
                $stmt->bindParam(':harga', $harga);
                $stmt->bindParam(':stok', $stok);
                $stmt->bindParam(':gambar', $target_file); // Simpan path gambar baru
            }
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang sudah ada
            $query = "UPDATE barang SET nama_barang=:nama_barang, harga=:harga, stok=:stok WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            // Bind parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nama_barang', $nama_barang);
            $stmt->bindParam(':harga', $harga);
            $stmt->bindParam(':stok', $stok);
        }
    
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    

    public function delete($id) {
        // Hapus barang berdasarkan ID
        $query = "DELETE FROM barang WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        
        // Bind parameter
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            // Setelah menghapus, reset ID
            $this->resetIds();
            return true;
        }
        return false;
    }
    
    private function resetIds() {
        // Mengatur ulang ID untuk semua barang
        $query = "SET @num := 0; 
                  UPDATE barang SET id = (@num := @num + 1); 
                  ALTER TABLE barang AUTO_INCREMENT = 1;";
        
        // Eksekusi query
        $this->conn->exec($query);
    }
    
}
?>
