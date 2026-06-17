<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des caisses</title>
</head>

<body>

    <form method="post" action="<?= site_url('caisse/valider') ?>">
        <label for="caisse">Choisir une caisse :</label>

        <select name="id_caisse" id="caisse">
            <option value="">-- Sélectionner une caisse --</option>

            <?php foreach ($caisses as $caisse): ?>
                <option value="<?= $caisse['id'] ?>">
                    <?= esc($caisse['designation']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Valider</button>
    </form>

</body>

</html>