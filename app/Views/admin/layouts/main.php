<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman E-Ternak Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --dark: #1e293b;
            --light: #f8fafc;
            --danger: #ef4444;
            --gray: #e2e8f0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--light);
            margin: 0;
            overflow-x: hidden;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 240px;
            background-color: var(--dark);
            color: white;
            transition: all 0.3s ease;
            z-index: 100;
        }

        .sidebar h4 {
            text-align: center;
            padding: 1.4rem 0;
            font-weight: 700;
            background-color: #0f172a;
            margin: 0;
            letter-spacing: 0.5px;
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

        /* ===== Navbar ===== */
        .navbar-admin {
            background-color: #ffffff;
            border-bottom: 1px solid var(--gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
            position: sticky;
            top: 0;
            z-index: 90;
            margin-left: 240px;
            transition: all 0.3s ease;
        }

        .navbar-admin h5 {
            margin: 0;
            font-weight: 600;
            color: #334155;
        }

        .navbar-admin .user-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .navbar-admin .user-name {
            font-weight: 500;
            color: var(--primary);
        }

        .logout-btn {
            background-color: var(--danger);
            border: none;
            color: white;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background-color: #dc2626;
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-left: 240px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* ===== Responsive ===== */
        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }

            .navbar-admin {
                margin-left: 200px;
            }

            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -240px;
            }

            .sidebar.active {
                left: 0;
            }

            .navbar-admin {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .toggle-btn {
                display: block;
            }
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
        <h4>E-Ternak Admin</h4>
        <a href="/admin" data-link="/admin">📊 Dashboard</a>
        <a href="/admin/products" data-link="/admin/products">📦 Kelola Produk</a>
        <a href="/admin/orders" data-link="/admin/orders">🧾 Kelola Pesanan</a>
    </div>

    <!-- Navbar -->
    <div class="navbar-admin">
        <div class="d-flex align-items-center gap-3">
            <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            <h5>Panel Admin</h5>
        </div>
        <div class="user-area">
            <span class="user-name">👤 <?= esc(session()->get('full_name') ?? 'Admin') ?></span>
            <form action="/logout" method="post" class="m-0">
                <?= csrf_field() ?>
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?= $this->renderSection('content') ?>
    </div>

    <script>
        // Toggle sidebar for mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Active menu detection by URL
        document.addEventListener("DOMContentLoaded", () => {
            const currentPath = window.location.pathname;
            document.querySelectorAll(".sidebar a").forEach(link => {
                if (currentPath.startsWith(link.getAttribute("data-link"))) {
                    link.classList.add("active");
                }
            });
        });
    </script>
</body>

</html>