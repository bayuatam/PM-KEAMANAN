<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="checkout-section">
    <div class="container">
        <h2 class="fw-bold">Checkout</h2>
        <p class="text-muted">Semua pesanan akan diambil di <strong>Tefa MI (Teaching Factory)</strong>.</p>
        <hr class="my-4">

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <div class="row g-5">
            
            <div class="col-lg-7 order-lg-2"> 
                
                <form action="/checkout/process" method="post">
                    <?= csrf_field() ?>
                    
                    <h4 class="mb-3">Detail Pelanggan</h4>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-5">
                        <label for="customer_whatsapp" class="form-label">No. WhatsApp</label>
                        <input type="text" class="form-control" id="customer_whatsapp" name="customer_whatsapp" placeholder="Contoh: 081234567890" required>
                    </div>

                    <h4 class="mb-3">Metode Pembayaran</h4>
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay-online" value="online">
                            <label class="form-check-label" for="pay-online">
                                Bayar Online (QRIS, Virtual Account, dll)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay-cod" value="cod" checked>
                            <label class="form-check-label" for="pay-cod">
                                Bayar di Tempat (COD di Tefa MI)
                            </label>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">Buat Pesanan</button>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-5 order-lg-1">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Ringkasan Pesanan</h4>
                        <hr>
                        <?php $total = 0; ?>
                        <?php if(!empty($cart_items)): ?>
                            <ul class="list-group list-group-flush mb-3">
                                <?php foreach($cart_items as $item): ?>
                                    <?php $total += $item['price'] * $item['quantity']; ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted"><?= esc($item['name']) ?> <small>(x<?= $item['quantity'] ?>)</small></span>
                                        <span class="fw-semibold">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-center text-muted">Keranjang belanja kosong.</p>
                        <?php endif; ?>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<?= $this->endSection() ?>