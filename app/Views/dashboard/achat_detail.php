<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail achat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .meta {
            margin: 12px 0;
        }

        .actions {
            margin-top: 18px;
        }
    </style>
</head>

<body>

    <h1>Détail de l'achat #<?= esc($achat['id']) ?></h1>

    <div class="meta">
        <p><strong>Date :</strong> <?= esc($achat['date']) ?></p>
        <p><strong>Caisse :</strong> <?= esc($achat['caisse'] ?? '') ?></p>
        <p><strong>Total :</strong> <?= esc($achat['total']) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($details as $detail): ?>
                <tr>
                    <td><?= esc($detail['designation']) ?></td>
                    <td><?= esc($detail['quantite']) ?></td>
                    <td><?= esc($detail['prixUnitaire']) ?></td>
                    <td><?= esc($detail['quantite'] * $detail['prixUnitaire']) ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($details)): ?>
                <tr>
                    <td colspan="4">Aucun détail disponible.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="actions">
        <a href="<?= site_url('dashboard/achats') ?>">Retour à la liste</a>
    </div>

</body>

</html>