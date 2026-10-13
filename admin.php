
<?php
declare(strict_types=1);

session_start();

// Administration disponible uniquement en local.
if (!in_array(
    $_SERVER['REMOTE_ADDR'] ?? '',
    ['127.0.0.1', '::1'],
    true
)) {
    http_response_code(403);
    exit('Administration disponible uniquement en local.');
}

require_once 'config.php';

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$erreur = '';
$succes = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!hash_equals(
        $_SESSION['csrf'],
        $_POST['csrf'] ?? ''
    )) {
        http_response_code(403);
        exit('Session invalide.');
    }

    $nom = trim($_POST['nom'] ?? '');
    $numero = filter_var(
        $_POST['numero'] ?? null,
        FILTER_VALIDATE_INT
    );
    $poste = trim($_POST['poste'] ?? '');
    $periode = trim($_POST['periode'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $photo = trim($_POST['photo'] ?? '');

    if (
        $nom === '' ||
        $numero === false ||
        $numero < 0 ||
        $numero > 99 ||
        $poste === '' ||
        $periode === '' ||
        $description === ''
    ) {
        $erreur = 'Veuillez remplir correctement tous les champs.';
    } elseif (
        strlen($nom) > 100 ||
        strlen($poste) > 60 ||
        strlen($periode) > 60 ||
        strlen($photo) > 100
    ) {
        $erreur = 'Un ou plusieurs champs sont trop longs.';
    } elseif (
        !preg_match('/^[a-zA-Z0-9_-]+\.jpg$/', $photo)
    ) {
        $erreur = 'Indiquez un nom de fichier JPG valide.';
    } else {
        $requete = $pdo->prepare(
            'INSERT INTO joueurs
            (nom, numero, poste, periode, description, photo)
            VALUES (?, ?, ?, ?, ?, ?)'
        );

        $requete->execute([
            $nom,
            $numero,
            $poste,
            $periode,
            $description,
            $photo
        ]);

        header('Location: admin.php?ajout=ok');
        exit;
    }
}

$succes = ($_GET['ajout'] ?? '') === 'ok';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration - Warriors Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="entete">
    <a class="logo" href="index.php">
        <img src="images/logo-warriors.png" alt="Logo Golden State Warriors">
        <span>Warriors Database</span>
    </a>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="joueurs.php">Joueurs</a>
        <a href="palmares.php">Palmarès</a>
    </nav>
</header>

<main class="conteneur">
    <div class="intro-page">
        <h1>Administration des joueurs</h1>
        <p>
            Ajouter un nouveau joueur dans la base MySQL.
        </p>
    </div>

    <div class="carte formulaire-admin">

        <?php if ($succes): ?>
            <p class="message-succes">
                Joueur ajouté avec succès !
            </p>
        <?php endif; ?>

        <?php if ($erreur !== ''): ?>
            <p class="message-erreur">
                <?= e($erreur) ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="admin.php">

            <input type="hidden" name="csrf"
                   value="<?= e($_SESSION['csrf']) ?>">

            <label for="nom">Nom du joueur</label>
            <input id="nom" type="text" name="nom"
                   maxlength="100" required>

            <label for="numero">Numéro</label>
            <input id="numero" type="number" name="numero"
                   min="0" max="99" required>

            <label for="poste">Poste</label>
            <select id="poste" name="poste" required>
                <option value="Meneur">Meneur</option>
                <option value="Arrière">Arrière</option>
                <option value="Ailier">Ailier</option>
                <option value="Ailier fort">Ailier fort</option>
                <option value="Pivot">Pivot</option>
            </select>

            <label for="periode">Période</label>
            <input id="periode" type="text"
                   name="periode"
                   placeholder="Ex : 2015 - 2022"
                   maxlength="60" required>

            <label for="description">Description</label>
            <textarea id="description"
                      name="description"
                      rows="5" required></textarea>

            <label for="photo">Nom de l'image</label>
            <input id="photo" type="text"
                   name="photo"
                   placeholder="exemple.jpg"
                   maxlength="100" required>

            <button type="submit" class="bouton">
                Ajouter le joueur
            </button>
        </form>

        <p>
            Les images doivent être placées
            manuellement dans le dossier images.
        </p>
    </div>
</main>

<footer>
    Administration locale - Warriors Database
</footer>

</body>
</html>
