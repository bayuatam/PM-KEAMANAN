<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Pesanan #<?= esc($order['id']) ?></h1>
    <a href="/admin/orders" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-success text-white">
                <i class="bi bi-person-fill"></i> Informasi Pelanggan
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> <?= esc($order['customer_name']) ?></p>
                <p class="mb-0"><strong>No. WhatsApp:</strong> <?= esc($order['customer_whatsapp']) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-success text-white">
                <i class="bi bi-info-circle-fill"></i> Status Transaksi
            </div>
            <div class="card-body">
                <?php
                $status = esc($order['order_status']);
                $status_text = strtoupper(str_replace('_', ' ', $status));
                $badge_class = 'bg-secondary';
                // Menggunakan warna yang sama dengan dashboard
                if ($status == 'processing' || $status == 'at_logistics') {
                    $badge_class = 'bg-warning text-dark';
                } elseif ($status == 'completed') {
                    $badge_class = 'bg-success';
                } elseif ($status == 'cancelled') {
                    $badge_class = 'bg-danger';
                }
                ?>
                <p><strong>Status:</strong> <span class="badge <?= $badge_class ?>"><?= $status_text ?></span></p>
                <p><strong>Metode Pembayaran:</strong> <span class="badge bg-success"><?= strtoupper(esc($order['payment_method'])) ?></span></p>
                <p class="mb-0"><strong>Total Pembayaran:</strong> <span class="text-success fw-bold">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></span></p>
            </div>
        </div>
    </div>
</div>

<h3 class="mt-4 fw-bold">Item yang Dipesan</h3>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-success">
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= esc($item['product_name']) ?></td>
                    <td><?= esc($item['quantity']) ?></td>
                    <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td colspan="3" class="text-end">GRAND TOTAL</td>
                <td class="text-success fs-5">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<?php if ($order['order_status'] != 'completed' && $order['order_status'] != 'cancelled' && $order['order_status'] != 'at_logistics'): ?>
    <div class="mt-4">
        <a href="/admin/orders/cancel/<?= $order['id'] ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin membatalkan pesanan ini? Stok akan dikembalikan.')">
            <i class="bi bi-x-circle"></i> Batalkan Pesanan
        </a>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>