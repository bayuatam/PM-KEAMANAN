<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kelola Produk Anda</h1> 
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="/admin/products/new" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Produk Baru
            </a>
        </div>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Harga / Satuan</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $key => $product): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td>
                                <img src="/uploads/products/<?= esc($product['image']) ?>" alt="<?= esc($product['name']) ?>" width="50" class="img-thumbnail">
                            </td>
                            <td><?= esc($product['name']) ?></td>
                            <td>Rp <?= number_format($product['price'], 0, ',', '.') ?> / <?= esc($product['unit']) ?></td>
                            <td><?= esc($product['stock']) ?></td>
                            <td>
                                <a href="/admin/products/edit/<?= $product['id'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <a href="/admin/products/delete/<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Anda belum memiliki produk.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>