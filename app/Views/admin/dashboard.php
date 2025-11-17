<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Penjual</h1>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Produk</h5>
                            <p class="card-text fs-4 fw-bold"><?= esc($total_products) ?></p>
                        </div>
                        <i class="bi bi-box-seam" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                     <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Pesanan Diproses</h5>
                            <p class="card-text fs-4 fw-bold"><?= esc($processing_orders) ?></p>
                        </div>
                        <i class="bi bi-arrow-repeat" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Pendapatan</h5>
                            <p class="card-text fs-4 fw-bold">Rp <?= number_format($total_revenue, 0, ',', '.') ?></p>
                        </div>
                        <i class="bi bi-cash-coin" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <i class="bi bi-bar-chart-line-fill"></i> Grafik Pendapatan (7 Hari Terakhir)
        </div>
        <div class="card-body">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Pesanan Perlu Diproses</h4>
        <a href="/admin/orders" class="btn btn-sm btn-outline-primary">Lihat Semua Pesanan</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm responsive-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Pesan</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                 <?php if (!empty($processing_orders_list)): ?>
                    <?php foreach ($processing_orders_list as $order): ?>
                        <tr>
                            <td data-label="ID Pesanan">#<?= esc($order['id']) ?></td>
                            <td data-label="Nama Pelanggan"><?= esc($order['customer_name']) ?></td>
                            <td data-label="Tanggal Pesan"><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                            <td data-label="Total">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                            <td data-label="Aksi">
                                <a href="/admin/orders/view/<?= $order['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Tidak ada pesanan yang perlu diproses. Kerja bagus!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= $chart_labels ?>,
                    datasets: [{
                        label: 'Pendapatan',
                        data: <?= $chart_data ?>,
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
<?= $this->endSection() ?>