<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="/assets/images/logo.jpg" alt="Logo E-Ternak" style="height: 40px;" class="me-2">
            <strong>E-Ternak</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="/products">Produk</a></li>
                <li class="nav-item"><a class="nav-link" href="/track">Lacak Pesanan</a></li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a href="/cart" class="nav-link position-relative">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span id="cart-counter" class="badge bg-danger rounded-pill position-absolute" style="top: 5px; right: -5px; font-size: 0.6em;">
                            <?= array_sum(array_column(session()->get('cart') ?? [], 'quantity')) ?>
                        </span>
                    </a>
                </li>
                </ul>
        </div>
    </div>
</nav>