<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="container my-5">
        <input type="hidden" class="csrf-token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

        <h1 class="mb-4 fw-bold">Keranjang Belanja</h1>

        <div class="row g-4">
            <div class="col-lg-8">
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <?php if (!empty($cart_items)): $total = 0; ?>
                            <?php foreach($cart_items as $item): $total += $item['price'] * $item['quantity']; ?>
                                <div class="row align-items-center mb-3 py-2 <?= !$item['is_available'] ? 'bg-light opacity-50' : '' ?>">
                                    <div class="col-md-2">
                                        <img src="/uploads/products/<?= esc($item['image']) ?>" class="img-fluid rounded" alt="<?= esc($item['name']) ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="mb-0"><?= esc($item['name']) ?></h5>
                                        <small class="text-muted">Harga: Rp <?= number_format($item['price'], 0, ',', '.') ?></small>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small">Kuantitas</label>
                                        <input type="number" class="form-control form-control-sm cart-quantity-input" style="width: 80px;" value="<?= $item['quantity'] ?>" min="1" data-id="<?= $item['id'] ?>" <?= !$item['is_available'] ? 'disabled' : '' ?>>
                                        <?php if (!$item['is_available']): ?>
                                            <small class="text-danger d-block mt-1 fw-bold">Stok Habis!</small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <p class="mb-0 fw-bold" id="subtotal-<?= $item['id'] ?>">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></p>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <a href="/cart/remove/<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger" title="Hapus item"><i class="bi bi-trash-fill"></i></a>
                                    </div>
                                </div>
                                <?php if(next($cart_items)): ?><hr><?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-cart-x" style="font-size: 4rem; color: #ccc;"></i>
                                <p class="mt-3 text-muted">Keranjang Anda masih kosong.</p>
                                <a href="/products" class="btn btn-success">Mulai Belanja</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                 <?php if (!empty($cart_items)): ?>
                    <a href="/cart/clear" class="btn btn-sm btn-link text-danger mt-2" onclick="return confirm('Anda yakin ingin mengosongkan keranjang?')">Kosongkan Keranjang</a>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3 fw-bold">Ringkasan Pesanan</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center fw-bold fs-5 px-0">
                                Total
                                <span id="grand-total" class="text-success">Rp <?= number_format($total ?? 0, 0, ',', '.') ?></span>
                            </li>
                        </ul>
                        <div class="d-grid mt-3">
                            <?php if (!$is_checkoutable && !empty($cart_items)): ?>
                                <div class="alert alert-danger small p-2">Hapus produk yang stoknya habis untuk melanjutkan.</div>
                            <?php endif; ?>
                            <a href="/checkout" class="btn btn-success btn-lg <?= !$is_checkoutable || empty($cart_items) ? 'disabled' : '' ?>">Lanjutkan ke Pembayaran</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>