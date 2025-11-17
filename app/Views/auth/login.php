<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('title') ?>Login Penjuall<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card" style="width: 25rem;">
    <div class="card-body p-5">
        <h3 class="card-title text-center mb-4">Login Penjual</h3>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="/login/process" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
            <p class="text-center mt-3 small">Belum punya akun? <a href="/admin/register">Daftar di sini</a></p>
        </form>
    </div>
</div>
<?= $this->endSection() ?>