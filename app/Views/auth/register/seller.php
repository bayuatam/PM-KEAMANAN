<?= $this->extend('layouts/auth_layout') ?>

<?= $this->section('title') ?>Daftar Penjual<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card" style="width: 25rem;">
    <div class="card-body p-5">
        <h3 class="card-title text-center mb-4">Daftar Penjual</h3>

        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php if(is_array(session()->getFlashdata('errors'))): ?>
                    <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                    </ul>
                <?php else: ?>
                    <?= session()->getFlashdata('errors') ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form action="/admin/register/process" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name') ?>" required>
            </div>
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" class="form-control" id="kelas" name="kelas" value="<?= old('kelas') ?>" required>
            </div>
            <div class="mb-3">
                <label for="prodi" class="form-label">Program Studi</label>
                <input type="text" class="form-control" id="prodi" name="prodi" value="<?= old('prodi') ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Daftarkan Akun</button>
            </div>
            <p class="text-center mt-3 small">Sudah punya akun? <a href="/login">Masuk di sini</a></p>
        </form>
    </div>
</div>
<?= $this->endSection() ?>