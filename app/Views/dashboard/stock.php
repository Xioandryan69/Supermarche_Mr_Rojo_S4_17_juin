<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1>Stock</h1>

<table>
    <thead>
        <tr>
            <th>Produit</th>
            <th>Catégorie</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produits as $produit): ?>
            <tr>
                <td><?= esc($produit['designation']) ?></td>
                <td><?= esc($produit['categorie'] ?? '-') ?></td>
                <td><?= esc($produit['stock']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
