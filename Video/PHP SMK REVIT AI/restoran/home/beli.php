<?php 
    if(isset($_GET['hapus'])){
        $id = $_GET['hapus'];
        unset($_SESSION['_'.$id]);
        header("location:?f=home&m=beli");
    }

    if(isset($_GET['tambah'])){
        $id = $_GET['tambah'];
        $_SESSION['_'.$id]++;
    }
    
    if(isset($_GET['kurang'])){
        $id = $_GET['kurang'];
        $_SESSION['_'.$id]--;
        if($_SESSION['_'.$id] == 0){
            unset($_SESSION['_'.$id]);
        }
    }

    if(!isset($_SESSION['pelanggan'])){
        header("location:?f=home&m=login");
    } else{       
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            isi($id);
            header("location:?f=home&m=beli");
        }  else{
            keranjang();
        }
    }
    
    function isi($id){
        if(isset($_SESSION['_'.$id])){
            $_SESSION['_'.$id]++;
        }else{
            $_SESSION['_'.$id]=1;
        }
    }

    function keranjang(){
        global $db;
        $total = 0;
        global $total;

        echo '<div class="cart-container">';
        echo '<div class="cart-header">
                <h3 class="cart-title"><i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja</h3>
                <a href="?f=home&m=produk" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-utensils me-1"></i>Tambah Menu
                </a>
              </div>';
        
        if(count($_SESSION) > 0){
            $cart_empty = true;
            
            foreach($_SESSION as $key => $value){
                if($key<>'pelanggan' && $key<> 'idpelanggan' && $key<> 'user' && $key<> 'level' && $key<> 'iduser'){
                    $cart_empty = false;
                    break;
                }
            }
            
            if($cart_empty){
                echo '<div class="cart-empty">
                    <div class="cart-empty-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h4>Keranjang Belanja Anda Kosong</h4>
                    <p>Anda belum menambahkan menu apapun ke keranjang</p>
                    <a href="?f=home&m=produk" class="btn btn-primary">
                        <i class="fas fa-utensils me-2"></i>Lihat Menu
                    </a>
                </div>';
            } else {
                echo '<div class="cart-items">';

                foreach($_SESSION as $key => $value){
                    if($key<>'pelanggan' && $key<> 'idpelanggan' && $key<> 'user' && $key<> 'level' && $key<> 'iduser'){
                        $id = substr($key,1);

                        $sql = "SELECT * FROM tablemenu WHERE idmenu=$id";
                        $row = $db -> getAll($sql);
                        
                        foreach($row as $r){
                            echo '<div class="cart-item">
                                <div class="cart-item-image">
                                    <img src="upload/'.$r['gambar'].'" alt="'.$r['menu'].'">
                                </div>
                                <div class="cart-item-details">
                                    <h5 class="cart-item-title">'.$r['menu'].'</h5>
                                    <div class="cart-item-price">Rp. '.number_format($r['harga'], 0, ',', '.').'</div>
                                </div>
                                <div class="cart-item-quantity">
                                    <a href="?f=home&m=beli&kurang='.$r['idmenu'].'" class="quantity-btn">
                                        <i class="fas fa-minus"></i>
                                    </a>
                                    <span class="quantity-value">'.$value.'</span>
                                    <a href="?f=home&m=beli&tambah='.$r['idmenu'].'" class="quantity-btn">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                                <div class="cart-item-subtotal">
                                    Rp. '.number_format($r['harga'] * $value, 0, ',', '.').'
                                </div>
                                <div class="cart-item-remove">
                                    <a href="?f=home&m=beli&hapus='.$r['idmenu'].'" class="remove-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>';
                            $total = $total + ($value * $r['harga']);
                        }
                    }
                }

                echo '</div>';
                
                echo '<div class="cart-summary">
                    <div class="cart-summary-row">
                        <span>Subtotal</span>
                        <span>Rp. '.number_format($total, 0, ',', '.').'</span>
                    </div>
                    <div class="cart-summary-row">
                        <span>Biaya Pengiriman</span>
                        <span>Gratis</span>
                    </div>
                    <div class="cart-summary-row total">
                        <span>Total</span>
                        <span>Rp. '.number_format($total, 0, ',', '.').'</span>
                    </div>
                    <a class="btn btn-primary btn-checkout" href="?f=home&m=checkout&total='.$total.'">
                        <i class="fas fa-check-circle me-2"></i>Checkout
                    </a>
                </div>';
            }
        } else {
            echo '<div class="cart-empty">
                <div class="cart-empty-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h4>Keranjang Belanja Anda Kosong</h4>
                <p>Anda belum menambahkan menu apapun ke keranjang</p>
                <a href="?f=home&m=produk" class="btn btn-primary">
                    <i class="fas fa-utensils me-2"></i>Lihat Menu
                </a>
            </div>';
        }
        
        echo '</div>';
    }
?>

<style>
    .cart-container {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .cart-header {
        padding: 20px 25px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .cart-title {
        font-size: 20px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }
    
    .cart-empty {
        padding: 60px 20px;
        text-align: center;
    }
    
    .cart-empty-icon {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: #94a3b8;
        font-size: 30px;
    }
    
    .cart-empty h4 {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 10px;
    }
    
    .cart-empty p {
        color: #64748b;
        margin-bottom: 25px;
    }
    
    .cart-items {
        padding: 20px 0;
    }
    
    .cart-item {
        display: grid;
        grid-template-columns: 80px 1fr auto auto auto;
        gap: 15px;
        align-items: center;
        padding: 15px 25px;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }
    
    .cart-item:hover {
        background-color: #f8fafc;
    }
    
    .cart-item-image {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .cart-item-title {
        font-size: 16px;
        font-weight: 500;
        color: #1e293b;
        margin: 0 0 5px;
    }
    
    .cart-item-price {
        color: #64748b;
        font-size: 14px;
    }
    
    .cart-item-quantity {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .quantity-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0ea5e9;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .quantity-btn:hover {
        background: #e0f2fe;
        color: #0284c7;
    }
    
    .quantity-value {
        font-weight: 500;
        color: #1e293b;
        min-width: 30px;
        text-align: center;
    }
    
    .cart-item-subtotal {
        font-weight: 500;
        color: #1e293b;
        text-align: right;
        min-width: 100px;
    }
    
    .remove-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #fee2e2;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .remove-btn:hover {
        background: #fecaca;
        transform: scale(1.05);
    }
    
    .cart-summary {
        background: #f8fafc;
        padding: 25px;
        border-top: 1px solid #e2e8f0;
    }
    
    .cart-summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        color: #64748b;
    }
    
    .cart-summary-row.total {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        padding-top: 15px;
        margin-top: 15px;
        border-top: 1px dashed #e2e8f0;
    }
    
    .btn-checkout {
        display: block;
        width: 100%;
        padding: 14px;
        margin-top: 20px;
        background: linear-gradient(135deg, #0ea5e9, #14b8a6);
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-checkout:hover {
        background: linear-gradient(135deg, #0284c7, #0f766e);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 60px 1fr auto;
            grid-template-rows: auto auto;
            gap: 10px;
            padding: 15px;
        }
        
        .cart-item-image {
            width: 60px;
            height: 60px;
            grid-row: span 2;
        }
        
        .cart-item-details {
            grid-column: 2;
        }
        
        .cart-item-quantity {
            grid-column: 3;
            grid-row: 1;
        }
        
        .cart-item-subtotal {
            grid-column: 2;
            grid-row: 2;
            text-align: left;
        }
        
        .cart-item-remove {
            grid-column: 3;
            grid-row: 2;
            justify-self: end;
        }
    }
</style>