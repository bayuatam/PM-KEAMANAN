<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- TAMBAHKAN PEMBUNGKUS CONTAINER DI SINI -->
<div class="container">
    <div class="text-center my-5">
        <h1 class="display-5 fw-bold"><?= esc($page_title) ?></h1>
    </div>

    <div class="row">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-6 mb-4">
                    <a href="/product/<?= $product['id'] ?>" class="text-decoration-none text-dark">
                        <div class="card h-100 product-card">
                            <img src="/uploads/products/<?= esc($product['image']) ?>" class="card-img-top" alt="<?= esc($product['name']) ?>" style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title mb-1"><?= esc($product['name']) ?></h6>
                                <p class="fw-bold mb-0">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted fs-4">Oops, tidak ada produk yang ditemukan dalam kategori ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- PENUTUP CONTAINER -->

<?= $this->endSection() ?>