<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Dashboard') ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f7fa;
            color: #1f2933;
        }

        header {
            background: #16324f;
            color: white;
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            margin-left: 16px;
            text-decoration: none;
        }

        main {
            max-width: 1100px;
            margin: 28px auto;
            padding: 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            border: 1px solid #d9e2ec;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #edf2f7;
        }

        .panel,
        .metric {
            background: white;
            border: 1px solid #d9e2ec;
            border-radius: 6px;
            padding: 18px;
            margin-bottom: 16px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 16px;
        }

        .actions a,
        button {
            display: inline-block;
            background: #1f6feb;
            color: white;
            border: 0;
            border-radius: 4px;
            padding: 9px 12px;
            text-decoration: none;
            cursor: pointer;
        }

        .muted {
            color: #62748a;
        }

        .alert {
            background: #ffe8e8;
            border: 1px solid #ffb8b8;
            padding: 10px;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    <header>
        <div>
            <strong>Supermarché Mr Rojo</strong>
            <span class="muted"> | <?= esc($caisse['designation'] ?? 'Aucune caisse') ?></span>
        </div>
        <nav>
            <a href="<?= site_url('dashboard') ?>">Dashboard</a>
            <a href="<?= site_url('achats') ?>">Vente</a>
            <a href="<?= site_url('dashboard/stock') ?>">Stock</a>
            <a href="<?= site_url('dashboard/achats') ?>">Achats</a>
            <a href="<?= site_url('/') ?>">Changer caisse</a>
            <a href="<?= site_url('logout') ?>">Déconnexion</a>
        </nav>
    </header>

    <main>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="panel"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>
</body>

</html>
