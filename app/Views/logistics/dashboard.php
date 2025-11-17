<?= $this->extend('logistics/layouts/main') ?>

<?= $this->section('content') ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <h1 class="h2 mb-4 fw-bold">Dashboard Tefa MI</h1> <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4><i class="bi bi-box-arrow-in-down"></i> Menunggu Barang dari Penjual</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover responsive-table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Penjual</th>
                            <th>Nama Pelanggan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($processing_orders)): ?>
                            <?php foreach($processing_orders as $order): ?>
                            <tr>
                                <td data-label="ID Pesanan"><strong>#<?= $order['id'] ?></strong></td>
                                <td data-label="Nama Penjual"><?= esc($order['seller_name']) ?></td>
                                <td data-label="Nama Pelanggan"><?= esc($order['customer_name']) ?></td>
                                <td data-label="Aksi">
                                    <div class="btn-group">
                                        <a href="/logistics/orders/view/<?= $order['id'] ?>" class="btn btn-info btn-sm">Detail</a>
                                        <a href="/logistics/confirm-reception/<?= $order['id'] ?>" class="btn btn-primary btn-sm" onclick="return confirm('Konfirmasi terima barang?')">Konfirmasi</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">Tidak ada pesanan yang sedang menunggu.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-dark">
            <h4><i class="bi bi-person-walking"></i> Siap Diambil oleh Pembeli di Tefa MI</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover responsive-table">
                     <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Pelanggan</th>
                            <th>Metode Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($ready_for_pickup_orders)): ?>
                            <?php foreach($ready_for_pickup_orders as $order): ?>
                            <tr>
                                <td data-label="ID Pesanan"><strong>#<?= $order['id'] ?></strong></td>
                                <td data-label="Nama Pelanggan"><?= esc($order['customer_name']) ?></td>
                                <td data-label="Metode Bayar">
                                    <?php if($order['payment_method'] == 'cod'): ?>
                                        <span class="badge bg-success">BAYAR DI TEMPAT</span>
                                    <?php else: ?>
                                        <span class="badge bg-info">SUDAH BAYAR</span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Aksi">
                                    <div class="btn-group">
                                        <a href="/logistics/orders/view/<?= $order['id'] ?>" class="btn btn-info btn-sm">Detail</a>
                                        <a href="/logistics/confirm-pickup/<?= $order['id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi pengambilan?')">Serahkan</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">Tidak ada pesanan yang siap diambil.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4><i class="bi bi-check2-circle"></i> Riwayat Pesanan Selesai</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover responsive-table">
                     <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal Selesai</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($completed_orders)): ?>
                            <?php foreach($completed_orders as $order): ?>
                            <tr>
                                <td data-label="ID Pesanan"><strong>#<?= $order['id'] ?></strong></td>
                                <td data-label="Nama Pelanggan"><?= esc($order['customer_name']) ?></td>
                                <td data-label="Tanggal Selesai"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></td>
                                <td data-label="Petugas"><?= esc($order['logistics_officer_name'] ?? 'N/A') ?></td>
                                <td data-label="Aksi">
                                    <a href="/logistics/orders/view/<?= $order['id'] ?>" class="btn btn-outline-info btn-sm">Lihat Arsip</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada pesanan yang selesai.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>