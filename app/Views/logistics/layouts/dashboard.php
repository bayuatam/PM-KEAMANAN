    <?= $this->extend('logistics/layouts/main') ?>

    <?= $this->section('content') ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <!-- Pesanan Menunggu Pengantaran dari Penjual -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Menunggu Pengantaran dari Penjual (Status: Diproses)</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($processing_orders as $order): ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= esc($order['customer_name']) ?></td>
                            <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                            <td>
                                <a href="/logistics/confirm-reception/<?= $order['id'] ?>" class="btn btn-primary btn-sm" onclick="return confirm('Konfirmasi terima barang dari penjual untuk pesanan ini?')">
                                    <i class="bi bi-box-arrow-in-down"></i> Konfirmasi Terima
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($processing_orders)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada pesanan yang sedang diproses.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pesanan Siap Diambil Pembeli -->
    <div class="card">
        <div class="card-header">
            <h4>Siap Diambil oleh Pembeli (Status: Di Logistik)</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Metode Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ready_for_pickup_orders as $order): ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= esc($order['customer_name']) ?></td>
                            <td>
                                <?php if ($order['payment_method'] == 'cod'): ?>
                                    <span class="badge bg-success">BAYAR DI TEMPAT</span>
                                <?php else: ?>
                                    <span class="badge bg-info">SUDAH BAYAR</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/logistics/confirm-pickup/<?= $order['id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi barang telah diambil oleh pelanggan?')">
                                    <i class="bi bi-check-circle"></i> Konfirmasi Pengambilan
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($ready_for_pickup_orders)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada pesanan yang siap diambil.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?= $this->endSection() ?>
    ```

    ### **Langkah 3: Perbarui Logika Login**
    Kita perlu mengarahkan pengguna ke dashboard yang benar berdasarkan perannya.

    1. Buka `app/Controllers/LoginController.php`.
    2. Ubah bagian `redirect` di dalam method `processLogin()`.

    ```php
    // app/Controllers/LoginController.php
    // ... di dalam method processLogin() ...

    // Ganti redirect yang lama dengan ini:
    if ($user['role'] == 'penjual') {
    return redirect()->to('/admin');
    } elseif ($user['role'] == 'logistik') {
    return redirect()->to('/logistics');
    } else {
    // Untuk pembeli, jika nanti ada login untuk mereka
    return redirect()->to('/');
    }
    ```

    ### **Langkah 4: Daftarkan Rute Baru**
    1. Buka `app/Config/Routes.php` dan tambahkan rute untuk logistik.

    ```php
    // Rute untuk Halaman Logistik
    $routes->get('/logistics', 'LogisticsController::index');
    $routes->get('/logistics/confirm-reception/(:num)', 'LogisticsController::confirmReception/$1');
    $routes->get('/logistics/confirm-pickup/(:num)', 'LogisticsController::confirmPickup/$1');