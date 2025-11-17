<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Produk</h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="/admin/products/update/<?= $product['id'] ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= esc($product['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori Produk</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= ($category['id'] == $product['category_id']) ? 'selected' : '' ?>>
                                        <?= esc($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk (Biarkan kosong jika tidak ingin diubah)</label>
                        <input class="form-control" type="file" id="image" name="image">
                        <img src="/uploads/products/<?= esc($product['image']) ?>" alt="Gambar saat ini" class="img-thumbnail mt-2" width="150">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= esc($product['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="price" name="price" value="<?= esc($product['price']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="unit" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="unit" name="unit" value="<?= esc($product['unit']) ?>" placeholder="/kg, /bungkus, dll">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?= esc($product['stock']) ?>" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui Produk</button>
                    <a href="/admin/products" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>