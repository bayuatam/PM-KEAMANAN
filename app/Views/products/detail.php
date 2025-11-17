<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= esc($product['name']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="row g-5">
        
        <div class="col-lg-6">
            <img src="/uploads/products/<?= esc($product['image']) ?>" class="img-fluid rounded shadow-sm w-100" alt="<?= esc($product['name']) ?>" style="object-fit: cover; max-height: 500px;">
        </div>
        
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold"><?= esc($product['name']) ?></h1>

            <h2 class="display-4 fw-bold text-success my-3">
                Rp <?= number_format($product['price'], 0, ',', '.') ?>
                <span class="fs-5 text-muted">/<?= esc($product['unit']) ?></span>
            </h2>
            
            <p class="text-muted fs-5">Stok Tersedia: <strong><?= esc($product['stock']) ?></strong></p>

            <hr class="my-4">

            <div class="d-grid gap-2 mb-4">
                 <a href="/cart/add/<?= $product['id'] ?>" class="btn btn-success btn-lg add-to-cart-btn">
                    <i class="bi bi-cart-plus-fill"></i> Tambah ke Keranjang
                </a>
            </div>
            
            <h5 class="fw-bold">Deskripsi Produk</h5>
            <p class="lead"><?= esc($product['description']) ?></p>

            <div class="mt-4 p-3 bg-white rounded border">
                <h5 class="fw-bold">Dijual oleh:</h5>
                <p class="mb-0"><strong><?= esc($product['seller_name']) ?></strong></p>
                <p class="text-muted mb-0"><?= esc($product['prodi']) ?> - <?= esc($product['kelas']) ?></p>
            </div>
        </div>
        
    </div>
</div>
<?= $this->endSection() ?>