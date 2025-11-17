<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="checkout-section">
    <div class="container">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="row g-5">
            <div class="col-lg-7">
                <h2 class="fw-bold">Checkout</h2>
                <p class="text-muted">Semua pesanan akan diambil di <strong>Tefa MI (Teaching Factory)</strong>.</p>
                <hr class="my-4">
                
                <form action="/checkout/process" method="post">
                    <?= csrf_field() ?>
                    
                    <h4>Detail Pelanggan</h4>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_whatsapp" class="form-label">No. WhatsApp</label>
                        <input type="text" class="form-control" id="customer_whatsapp" name="customer_whatsapp" placeholder="Contoh: 081234567890" required>
                    </div>

                    <h4 class="mt-4">Metode Pembayaran</h4>
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

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success btn-lg">Buat Pesanan</button>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Ringkasan Pesanan</h4>
                        <hr>
                        <?php $total = 0; ?>
                        <?php if(!empty($cart_items)): ?>
                            <?php foreach($cart_items as $item): ?>
                                <?php $total += $item['price'] * $item['quantity']; ?>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><?= esc($item['name']) ?> x <?= $item['quantity'] ?></span>
                                    <span>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
                                </div>
                            <?php endforeach; ?>
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