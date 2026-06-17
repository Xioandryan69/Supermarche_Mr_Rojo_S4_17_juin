<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            display: grid;
            place-items: center;
            min-height: 100vh;
            margin: 0;
        }

        form {
            width: min(360px, calc(100% - 32px));
            background: white;
            border: 1px solid #d9e2ec;
            border-radius: 6px;
            padding: 24px;
        }

        label,
        input,
        button {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        input {
            margin: 6px 0 14px;
            padding: 10px;
            border: 1px solid #bcccdc;
            border-radius: 4px;
        }

        button {
            background: #1f6feb;
            color: white;
            border: 0;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
        }

        .error {
            background: #ffe8e8;
            border: 1px solid #ffb8b8;
            padding: 10px;
            margin-bottom: 14px;
        }
    </style>
</head>

<body>
    <form method="post" action="<?= site_url('login') ?>">
        <h1>Connexion</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <label for="username">Utilisateur</label>
        <input id="username" name="username" value="<?= old('username') ?>" required>

        <label for="password">Mot de passe</label>
        <input id="password" name="password" type="password" required>

        <button type="submit">Se connecter</button>
    </form>
</body>

</html>
