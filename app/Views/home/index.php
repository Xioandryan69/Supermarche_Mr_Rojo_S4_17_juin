<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Choisir une caisse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
        }

        header {
            background: #16324f;
            color: white;
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
        }

        header a {
            color: white;
            text-decoration: none;
        }

        main {
            max-width: 720px;
            margin: 40px auto;
            padding: 0 20px;
        }

        form {
            background: white;
            border: 1px solid #d9e2ec;
            border-radius: 6px;
            padding: 22px;
        }

        select,
        button {
            width: 100%;
            box-sizing: border-box;
            margin-top: 8px;
            padding: 10px;
        }

        button {
            background: #1f6feb;
            color: white;
            border: 0;
            border-radius: 4px;
            cursor: pointer;
        }

        .error {
            background: #ffe8e8;
            border: 1px solid #ffb8b8;
            padding: 10px;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    <header>
        <strong>Supermarché Mr Rojo</strong>
        <a href="<?= site_url('logout') ?>">Déconnexion</a>
    </header>

    <main>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('caisse/valider') ?>">
            <h1>Choisir une caisse</h1>
            <label for="id_caisse">Caisse</label>
            <select id="id_caisse" name="id_caisse" required>
                <?php foreach ($caisses as $caisse): ?>
                    <option value="<?= $caisse['id'] ?>"><?= esc($caisse['designation']) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Entrer dans le dashboard</button>
        </form>
    </main>
</body>

</html>
