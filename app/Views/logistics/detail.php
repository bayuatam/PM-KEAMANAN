<?= $this->extend('logistics/layouts/main') ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Pesanan #<?= esc($order['id']) ?></h1>
        <a href="/logistics" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Informasi Pelanggan</strong>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> <?= esc($order['customer_name']) ?></p>
                    <p class="mb-0"><strong>No. WhatsApp:</strong> <?= esc($order['customer_whatsapp']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Informasi Pesanan</strong>
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> <span class="badge bg-primary"><?= esc($order['order_status']) ?></span></p>
                    <p class="mb-0"><strong>Metode Pembayaran:</strong> <span class="badge bg-success"><?= esc($order['payment_method']) ?></span></p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Rincian Produk</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach($items as $item): ?>
                    <tr>
                        <td><?= esc($item['product_name']) ?></td>
                        <td><?= esc($item['quantity']) ?></td>
                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada item dalam pesanan ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr class="fw-bold fs-5">
                    <td colspan="3" class="text-end">Total Pembayaran</td>
                    <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
<?= $this->endSection() ?>