<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kelola Pesanan Anda</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Bayar</th>
                    <th>Metode Bayar</th>
                    <th>Status Pesanan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= esc($order['id']) ?></td>
                            <td><?= esc($order['customer_name']) ?></td>
                            <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                            <td>
                                <?php if($order['payment_method'] == 'cod'): ?>
                                    <span class="badge bg-success">COD</span>
                                <?php else: ?>
                                    <span class="badge bg-info">ONLINE</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $status = $order['order_status'];
                                    $badge_class = 'bg-secondary';
                                    $status_text = 'Tidak Diketahui';

                                    if ($status == 'pending_payment') {
                                        $badge_class = 'bg-warning text-dark';
                                        $status_text = 'Menunggu Pembayaran';
                                    } elseif ($status == 'processing') {
                                        $badge_class = 'bg-primary';
                                        $status_text = 'Diproses';
                                    } elseif ($status == 'at_logistics') {
                                        $badge_class = 'bg-info text-dark';
                                        $status_text = 'Di Logistik';
                                    } elseif ($status == 'completed') {
                                        $badge_class = 'bg-success';
                                        $status_text = 'Selesai';
                                    } elseif ($status == 'cancelled') {
                                        $badge_class = 'bg-danger';
                                        $status_text = 'Dibatalkan';
                                    }
                                ?>
                                <span class="badge <?= $badge_class ?>"><?= $status_text ?></span>
                            </td>
                            <td><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></td>
                            <td>
                                <a href="/admin/orders/view/<?= $order['id'] ?>" class="btn btn-sm btn-outline-info">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Anda belum memiliki pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>
