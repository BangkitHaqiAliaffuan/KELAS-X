<?php 
    if(isset($_GET['total'])){
        $total = $_GET['total'];
        $idorder = idorder();
        $idpelanggan = $_SESSION['idpelanggan'];
        $tgl = date('Y-m-d');

        $sql = "SELECT * FROM tableorder WHERE idorder = $idorder";

        $count = $db -> rowCOUNT($sql);

        if($count == 0){
            insertOrder($idorder, $idpelanggan,  $tgl, $total);
            insertOrderDetail($idorder);
        } else{
            insertOrderDetail($idorder);
        }
        
        kosongkanSession();
        header("location:?f=home&m=checkout");

    } else{
        info();
    }
    
    function info(){
        echo '<div class="checkout-success">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="success-title">Pesanan Berhasil!</h3>
            <p class="success-message">Terima kasih telah berbelanja di Restoran SMK. Pesanan Anda telah berhasil diproses dan sedang disiapkan.</p>
            <div class="order-timeline">
                <div class="timeline-item active">
                    <div class="timeline-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="timeline-content">
                        <h6>Pesanan Diterima</h6>
                        <p>Pesanan Anda telah kami terima</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="timeline-content">
                        <h6>Sedang Diproses</h6>
                        <p>Chef kami sedang menyiapkan pesanan Anda</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="timeline-content">
                        <h6>Pengiriman</h6>
                        <p>Pesanan Anda sedang dalam perjalanan</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="timeline-content">
                        <h6>Selesai</h6>
                        <p>Pesanan telah diterima</p>
                    </div>
                </div>
            </div>
            <div class="action-buttons">
                <a href="?f=home&m=histori" class="btn btn-outline-primary">
                    <i class="fas fa-history me-2"></i>Lihat Riwayat Pesanan
                </a>
                <a href="?f=home&m=produk" class="btn btn-primary">
                    <i class="fas fa-utensils me-2"></i>Pesan Lagi
                </a>
            </div>
        </div>';
    }

    function idorder(){
        global $db;
        $sql = "SELECT idorder FROM tableorder ORDER BY idorder DESC";
        $jumlah = $db -> rowCOUNT($sql);
        if($jumlah == 0){
            $id = 1;
        }else {
            $item = $db -> getITEM($sql);
            $id = $item['idorder']+1;
        }
        return $id;
    }

    function insertOrder($idorder, $idpelanggan, $tgl, $total){
        global $db;
        
        $sql = "INSERT INTO tableorder VALUES ($idorder, $idpelanggan, '$tgl', $total,0,0,0)";

        $db -> runSQL($sql);
    }

    function insertOrderDetail($idorder=1){
        global $db;
        foreach ($_SESSION as $key => $value){
            if($key<>'pelanggan' && $key<> 'idpelanggan'){
                $id = substr($key,1);

            $sql = "SELECT * FROM tablemenu WHERE idmenu=$id";
            $row = $db -> getAll($sql);

            foreach($row as $r){
                $idmenu = $r['idmenu'];
                $harga = $r['harga'];
                $sql = "INSERT INTO tableorderdetail VALUES 
                ('',$idorder,$idmenu,$value,$harga)";
                $db -> runSQL($sql);

            }
            }
        }
    }

    function kosongkanSession(){
        foreach ($_SESSION as $key => $value){
            if($key<>'pelanggan' && $key<> 'idpelanggan' && $key<> 'user' && $key<> 'level' && $key<> 'iduser'){
                $id = substr($key,1);
                unset($_SESSION['_'.$id]);
            }
        }
    }
?>

<style>
    .checkout-success {
        max-width: 700px;
        margin: 40px auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 40px;
        text-align: center;
        animation: fadeInUp 0.5s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .success-icon {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        box-shadow: 0 10px 20px rgba(14, 165, 233, 0.2);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(14, 165, 233, 0.4);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(14, 165, 233, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(14, 165, 233, 0);
        }
    }
    
    .success-icon i {
        font-size: 40px;
        color: white;
    }
    
    .success-title {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
    }
    
    .success-message {
        font-size: 16px;
        color: #64748b;
        margin-bottom: 30px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .order-timeline {
        margin: 40px 0;
        position: relative;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .order-timeline:before {
        content: '';
        position: absolute;
        top: 0;
        left: 20px;
        height: 100%;
        width: 2px;
        background: #e2e8f0;
    }
    
    .timeline-item {
        position: relative;
        padding-left: 50px;
        margin-bottom: 25px;
        text-align: left;
        opacity: 0.5;
        transition: all 0.3s ease;
    }
    
    .timeline-item.active {
        opacity: 1;
    }
    
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    
    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 40px;
        height: 40px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }
    
    .timeline-item.active .timeline-icon {
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        border-color: #0ea5e9;
        color: white;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.2);
    }
    
    .timeline-content h6 {
        font-weight: 600;
        font-size: 16px;
        margin: 0 0 5px;
        color: #1e293b;
    }
    
    .timeline-content p {
        margin: 0;
        font-size: 14px;
        color: #64748b;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 40px;
    }
    
    .action-buttons .btn {
        padding: 12px 24px;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        border: none;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #0284c7, #0f766e);
    }
    
    .btn-outline-primary {
        color: #0ea5e9;
        border: 1px solid #0ea5e9;
        background: transparent;
    }
    
    .btn-outline-primary:hover {
        background: rgba(14, 165, 233, 0.1);
        color: #0284c7;
    }
</style>