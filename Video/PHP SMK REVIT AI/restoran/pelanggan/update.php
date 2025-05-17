<?php 

if (isset($_GET['id'])){
  $id = $_GET['id'];
  $aktif = 1;
  
  $row = $db -> getITEM("SELECT * FROM tablepelanggan WHERE idpelanggan = $id");

  if ($row['aktif'] == 0){
    $aktif = 1;
  } else {
    $aktif = 0;
  }

  $sql = "UPDATE tablepelanggan  SET aktif = $aktif WHERE idpelanggan = $id";

  $db->runSQL($sql);

  header("location:?f=pelanggan&m=select");
}

?>