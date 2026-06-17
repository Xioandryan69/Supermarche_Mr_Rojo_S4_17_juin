<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<h1>Achats</h1>

<table>
    <thead>
        <tr>
            <th>N°</th>
            <th>Date</th>
            <th>Caisse</th>
            <th>Total</th>
            <th>Détail</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($achats)): ?>
            <tr>
                <td colspan="5">Aucun achat enregistré.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($achats as $achat): ?>
            <tr>
                <td><?= esc($achat['id']) ?></td>
                <td><?= esc($achat['date']) ?></td>
                <td><?= esc($achat['caisse'] ?? '-') ?></td>
                <td><?= esc($achat['total'] ?? 0) ?> Ar</td>
                <td><a href="<?= site_url('dashboard/achats/' . $achat['id']) ?>">Voir</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
