<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="container">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="hero-section-image text-center my-4 shadow-lg">
            <h1 class="display-4 fw-bold">Segar Langsung dari Peternakan</h1>
            <p class="lead col-lg-8 mx-auto">Produk berkualitas tinggi dari lingkungan kampus Politeknik Negeri Lampung. Terjamin, bersih, dan segar.</p>
            <a href="/products" class="btn btn-light btn-lg mt-3">Belanja Sekarang</a>
        </div>
    </div>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Telusuri Kategori</h3>
            <a href="#" class="text-success fw-bold text-decoration-none category-filter-btn" data-category-id="all">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        
        <div class="row g-4">
            <div class="col-6 col-md-3 col-lg-2">
                <a href="#" class="category-item text-decoration-none text-dark text-center d-block category-filter-btn" data-category-id="all">
                    <div class="category-icon-wrapper shadow-sm">
                        <i class="bi bi-grid-fill fs-1 text-primary"></i> 
                    </div>
                    <h6 class="mt-2 mb-0 fw-bold">Semua Produk</h6>
                </a>
            </div>

            <?php if (!empty($categories)): ?>
                <?php $icons = ['bi-egg-fried', 'bi-egg', 'bi-cup-straw', 'bi-basket-fill', 'bi-box-seam']; ?>
                <?php foreach($categories as $index => $category): ?>
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="#" class="category-item text-decoration-none text-dark text-center d-block category-filter-btn" data-category-id="<?= $category['id'] ?>">
                            <div class="category-icon-wrapper shadow-sm">
                                <i class="bi <?= $icons[$index % count($icons)] ?> fs-1 text-primary"></i>
                            </div>
                            <h6 class="mt-2 mb-0 fw-bold"><?= esc($category['name']) ?></h6>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="product-section py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Produk Populer</h3>
                <a href="#" class="text-success fw-bold text-decoration-none category-filter-btn" data-category-id="all">Tampila Semua <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="row" id="product-list-container">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-3 col-md-4 col-6 mb-4 product-item" data-category-id="<?= $product['category_id'] ?>">
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
                        <p>Saat ini belum ada produk yang tersedia.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>