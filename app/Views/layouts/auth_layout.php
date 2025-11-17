<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - E-Ternak</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .auth-wrapper {
            min-height: calc(100vh - 120px); /* 100% tinggi viewport dikurangi tinggi header & footer */
        }
    </style>
</head>
<body class="d-flex flex-column vh-100">

    <?= $this->include('layouts/partials/navbar') ?>

    <main class="d-flex align-items-center justify-content-center auth-wrapper">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('layouts/partials/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>