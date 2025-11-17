<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container text-center py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
            <h1 class="mt-3">Pesanan Berhasil Dibuat!</h1>
            
            <p class="lead">
                Terima kasih telah berbelanja. ID Pesanan Anda adalah:
            </p>
            <h2 class="my-3">
                <span class="badge bg-primary">#<?= esc($order['id']) ?></span>
            </h2>

            <?php if ($order['payment_method'] == 'cod'): ?>
                <p class="text-muted">
                    Penjual akan segera memproses pesanan Anda. Silakan lacak status pesanan Anda secara berkala. Anda akan dihubungi jika pesanan sudah siap diambil di <strong>Tefa MI</strong>.
                </p>
                <p><strong>Silakan lakukan pembayaran secara tunai saat mengambil barang.</strong></p>
            <?php else: ?>
                 <p class="text-muted">
                    Silakan lanjutkan pembayaran Anda. Penjual akan memproses pesanan setelah pembayaran terkonfirmasi.
                </p>
            <?php endif; ?>

            <div class="d-flex justify-content-center gap-2 mt-4">
                <a href="/track" class="btn btn-primary">Lacak Pesanan Saya</a>
                <a href="/" class="btn btn-outline-secondary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>