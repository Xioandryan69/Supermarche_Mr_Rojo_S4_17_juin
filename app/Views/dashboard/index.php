<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1>Dashboard</h1>

<div class="grid">
    <div class="metric">
        <strong>Produits</strong>
        <h2><?= esc($resume['produits']) ?></h2>
    </div>
    <div class="metric">
        <strong>Achats</strong>
        <h2><?= esc($resume['achats']) ?></h2>
    </div>
    <div class="metric">
        <strong>Total ventes</strong>
        <h2><?= esc($resume['total']) ?> Ar</h2>
    </div>
</div>

<div class="panel actions">
    <h2>Caisse active : <?= esc($caisse['designation']) ?></h2>
    <a href="<?= site_url('achats') ?>">Nouvelle vente</a>
    <a href="<?= site_url('dashboard/stock') ?>">Voir le stock</a>
    <a href="<?= site_url('dashboard/achats') ?>">Voir les achats</a>
</div>
<?= $this->endSection() ?>
