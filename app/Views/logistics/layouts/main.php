<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>E-Ternak Admin</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* =======================
       VARIABEL & BASE STYLE
    ======================= */
    :root {
      --primary: #2563eb;
      --dark: #1e293b;
      --light: #f8fafc;
      --danger: #ef4444;
      --sidebar-width: 240px;
      --brand-bg: #0f172a;
    }

    body {
      font-family: "Segoe UI", sans-serif;
      background-color: var(--light);
      margin: 0;
      overflow-x: hidden;
      padding-top: 56px; /* ruang untuk header */
    }

    /* =======================
       SIDEBAR
    ======================= */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: var(--sidebar-width);
      background-color: var(--dark);
      color: white;
      transition: all 0.3s ease;
      z-index: 1000;
    }

    .sidebar h4 {
      text-align: center;
      padding: 1.4rem 0;
      font-weight: 700;
      background-color: var(--brand-bg);
      color: white;
      margin: 0;
      letter-spacing: 0.5px;
      height: 56px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .sidebar a {
      display: block;
      padding: 12px 20px;
      color: #cbd5e1;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: var(--primary);
      color: #fff;
    }

    .sidebar a .bi {
      margin-right: 10px;
      color: inherit;
    }

    /* =======================
       NAVBAR (HEADER)
    ======================= */
    .navbar-admin {
      background-color: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 20px;
      position: fixed;
      top: 0;
      z-index: 900;
      height: 56px;
      width: calc(100% - var(--sidebar-width));
      margin-left: var(--sidebar-width);
      transition: all 0.3s ease;
    }

    .navbar-admin .user-area {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .navbar-admin .user-name {
      font-weight: 500;
      color: var(--primary);
      text-decoration: none;
    }

    .logout-btn {
      background-color: var(--danger);
      border: none;
      color: white;
      padding: 6px 14px;
      border-radius: 6px;
      transition: all 0.2s;
    }

    /* =======================
       MAIN CONTENT
    ======================= */
    .main-content {
      margin-left: var(--sidebar-width);
      padding: 20px;
      padding-top: 76px;
      transition: all 0.3s ease;
    }

    /* =======================
       RESPONSIVE DESIGN
    ======================= */
    @media (max-width: 992px) {
      .sidebar { width: 200px; }
      .navbar-admin { 
        margin-left: 200px; 
        width: calc(100% - 200px);
      }
      .main-content { margin-left: 200px; }
    }

    @media (max-width: 768px) {
      .sidebar { left: calc(var(--sidebar-width) * -1); }
      .sidebar.active { left: 0; }
      .navbar-admin { 
        margin-left: 0; 
        width: 100%;
      }
      .main-content { margin-left: 0; }
      .toggle-btn { display: block !important; }
    }

    .toggle-btn {
      background: none;
      border: none;
      color: var(--primary);
      font-size: 1.6rem;
      display: none;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <h4><i class="bi bi-person-workspace me-2"></i> E-Ternak Admin</h4>
    <ul class="nav flex-column mt-3">
      <li class="nav-item">
        <a href="/admin" id="nav-dashboard"><i class="bi bi-house-door-fill"></i> Dashboard</a>
      </li>
      <li class="nav-item">
        <a href="/admin/products" id="nav-products"><i class="bi bi-box-seam-fill"></i> Kelola Produk</a>
      </li>
      <li class="nav-item">
        <a href="/admin/orders" id="nav-orders"><i class="bi bi-file-earmark-text-fill"></i> Kelola Pesanan</a>
      </li>
    </ul>
  </div>

  <!-- Navbar -->
  <div class="navbar-admin shadow-sm">
    <div class="d-flex align-items-center gap-3">
      <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
      <h5 class="m-0">Panel Admin</h5>
    </div>
    <div class="user-area dropdown">
      <a class="user-name dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        👤 <?= session()->get('full_name') ?? 'Admin' ?>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container-fluid">
      <?= $this->renderSection('content') ?>
    </div>
  </div>

  <!-- Script -->
  <script>
    // Toggle sidebar on mobile
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
    }

    // Active link detection
    document.addEventListener('DOMContentLoaded', function() {
      const currentPath = window.location.pathname;
      const navLinks = document.querySelectorAll('.sidebar a');

      navLinks.forEach(link => {
        link.classList.remove('active');
        const href = link.getAttribute('href');
        if (currentPath === href || currentPath.startsWith(href + '/')) {
          link.classList.add('active');
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
