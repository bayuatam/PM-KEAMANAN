<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= esc($product['name']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="row g-5">
        <div class="col-lg-6">
            <div class="ratio ratio-1x1 rounded overflow-hidden shadow-sm">
                <img src="/uploads/products/<?= esc($product['image']) ?>" 
                     class="w-100 h-100 object-fit-cover" 
                     alt="<?= esc($product['name']) ?>">
            </div>
        </div>

        <div class="col-lg-6">
            <h1 class="display-5 fw-bold mb-3"><?= esc($product['name']) ?></h1>

            <h2 class="display-6 fw-bold text-success mb-3">
                Rp <?= number_format($product['price'], 0, ',', '.') ?>
                <span class="fs-5 text-muted">/<?= esc($product['unit']) ?></span>
            </h2>

            <p class="text-muted fs-5">Stok Tersedia: <strong><?= esc($product['stock']) ?></strong></p>

            <hr class="my-4">

            <div class="d-grid gap-2 mb-4">
                <a href="/cart/add/<?= $product['id'] ?>" class="btn btn-success btn-lg shadow-sm">
                    <i class="bi bi-cart-plus-fill"></i> Tambah ke Keranjang
                </a>
            </div>

            <h5 class="fw-bold">Deskripsi Produk</h5>
            <p class="lead text-secondary"><?= esc($product['description']) ?></p>

            <div class="mt-4 p-3 bg-light rounded border">
                <h5 class="fw-bold mb-1">Dijual oleh:</h5>
                <p class="mb-0"><strong><?= esc($product['seller_name']) ?></strong></p>
                <p class="text-muted mb-0"><?= esc($product['prodi']) ?> - <?= esc($product['kelas']) ?></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>