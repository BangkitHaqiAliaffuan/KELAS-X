<?php 
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        $sql = "SELECT o.*, p.pelanggan, p.alamat 
                FROM tableorder o 
                JOIN tablepelanggan p ON o.idpelanggan = p.idpelanggan 
                WHERE o.idorder=$id";
        
        $row = $db->getITEM($sql);

        // Get order details
        $orderDetails = $db->getALL("SELECT od.*, m.menu, m.gambar 
                                    FROM tableorderdetail od 
                                    JOIN tablemenu m ON od.idmenu = m.idmenu 
                                    WHERE od.idorder=$id");
    }
?>

<div class="form-container">
    <h2 class="form-title"><i class="fas fa-money-bill-wave"></i> Proses Pembayaran</h2>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted">ID Pesanan:</label>
                        <p class="fw-bold">#<?php echo $id; ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Pelanggan:</label>
                        <p class="fw-bold"><?php echo $row['pelanggan']; ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Alamat:</label>
                        <p><?php echo $row['alamat']; ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Tanggal Order:</label>
                        <p><?php echo date('d M Y H:i', strtotime($row['tglorder'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0"><i class="fas fa-shopping-basket me-2"></i>Detail Pesanan</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Menu</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orderDetails as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="../upload/<?php echo $item['gambar']; ?>" alt="<?php echo $item['menu']; ?>" class="me-2" style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px;">
                                            <?php echo $item['menu']; ?>
                                        </div>
                                    </td>
                                    <td class="text-center"><?php echo $item['jumlah']; ?></td>
                                    <td class="text-end">Rp <?php echo number_format($item['hargajual'], 0, ',', '.'); ?></td>
                                    <td class="text-end">Rp <?php echo number_format($item['jumlah'] * $item['hargajual'], 0, ',', '.'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th class="text-end">Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0"><i class="fas fa-credit-card me-2"></i>Form Pembayaran</h5>
        </div>
        <div class="card-body">
            <form action="" method="post" class="fade-in">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="total" class="form-label">Total Tagihan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="total" name="total" required value="<?php echo $row['total'] ?>" class="form-control" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="bayar" class="form-label">Jumlah Bayar</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="bayar" name="bayar" required class="form-control" autofocus>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i> Masukkan jumlah uang yang dibayarkan oleh pelanggan.
                        </div>
                        
                        <div class="quick-amount">
                            <label class="form-label">Pilihan Cepat:</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-outline-primary quick-amount-btn" data-amount="<?php echo $row['total']; ?>">Uang Pas</button>
                                <button type="button" class="btn btn-outline-primary quick-amount-btn" data-amount="<?php echo $row['total'] + 10000; ?>">+10.000</button>
                                <button type="button" class="btn btn-outline-primary quick-amount-btn" data-amount="<?php echo $row['total'] + 50000; ?>">+50.000</button>
                                <button type="button" class="btn btn-outline-primary quick-amount-btn" data-amount="<?php echo $row['total'] + 100000; ?>">+100.000</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="?f=order&m=select" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" name="simpan" class="btn btn-primary">
                        <i class="fas fa-check"></i> Proses Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
    if(isset($_POST['simpan'])){
        $bayar = $_POST['bayar'];
        $kembali = $bayar - $row['total'];
        
        if($kembali < 0){
            echo '<div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error!</strong> Jumlah pembayaran kurang dari total tagihan.
                  </div>';
        } else {
            $sql = "UPDATE tableorder SET bayar='$bayar', kembali = $kembali, status=1 WHERE idorder=$id";
            $db->runSQL($sql);
            
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "?f=order&m=select";
                    }, 1000);
                  </script>';
                  
            echo '<div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Sukses!</strong> Pembayaran berhasil diproses. Kembalian: Rp '.number_format($kembali, 0, ',', '.').'.
                    <div class="mt-2">Mengalihkan ke halaman order...</div>
                  </div>';
        }
    }
?>

<script>
    // Quick amount buttons
    document.addEventListener('DOMContentLoaded', function() {
        const quickAmountBtns = document.querySelectorAll('.quick-amount-btn');
        const bayarInput = document.getElementById('bayar');
        
        quickAmountBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const amount = this.getAttribute('data-amount');
                bayarInput.value = amount;
            });
        });
    });
    
</script>

## JavaScript for Interactivity (admin.js)
