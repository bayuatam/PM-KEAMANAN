<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="track-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-truck fs-1 text-success"></i>
                            <h2 class="fw-bold mt-3">Lacak Pesanan Anda</h2>
                            <p class="text-muted">Masukkan ID Pesanan yang Anda terima setelah checkout.</p>
                        </div>
                        
                        <form action="/track/process" method="post">
                            <?= csrf_field() ?>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="order_id" placeholder="Contoh: 123" required>
                                <button class="btn btn-success" type="submit">Lacak</button>
                            </div>
                        </form>

                        <?php if(isset($order)): ?>
                            <hr class="my-4">
                            <?php if($order): ?>
                                <h4 class="mb-3">Hasil Pelacakan untuk Pesanan #<?= esc($order['id']) ?></h4>
                                <?php 
                                    $status = $order['order_status'];
                                    $badge_class = 'bg-secondary';
                                    $status_text = 'Status Tidak Diketahui';
                                    $status_desc = 'Pesanan Anda tidak dapat ditemukan.';

                                    if ($status == 'pending_payment') {
                                        $badge_class = 'bg-warning text-dark';
                                        $status_text = 'Menunggu Pembayaran';
                                        $status_desc = 'Selesaikan pembayaran Anda agar pesanan dapat diproses oleh penjual.';
                                    } elseif ($status == 'processing') {
                                        $badge_class = 'bg-primary';
                                        $status_text = 'Sedang Diproses';
                                        // PERUBAHAN TULISAN
                                        $status_desc = 'Pesanan Anda sedang disiapkan oleh penjual dan akan segera diantar ke Tefa MI.';
                                    } elseif ($status == 'at_logistics') {
                                        $badge_class = 'bg-info text-dark';
                                        $status_text = 'Siap Diambil';
                                        // PERUBAHAN TULISAN
                                        $status_desc = 'Pesanan Anda sudah tiba! Silakan ambil di Tefa MI.';
                                    } elseif ($status == 'completed') {
                                        $badge_class = 'bg-success';
                                        $status_text = 'Selesai';
                                        $status_desc = 'Pesanan Anda telah berhasil diambil.';
                                    } elseif ($status == 'cancelled') {
                                        $badge_class = 'bg-danger';
                                        $status_text = 'Dibatalkan';
                                        $status_desc = 'Pesanan Anda telah dibatalkan.';
                                    }
                                ?>
                                <div class="alert alert-light border">
                                    <p class="mb-1"><strong>Status:</strong> <span class="badge <?= $badge_class ?>"><?= $status_text ?></span></p>
                                    <p class="mb-0"><?= $status_desc ?></p>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-danger">
                                    Pesanan dengan ID tersebut tidak ditemukan.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>