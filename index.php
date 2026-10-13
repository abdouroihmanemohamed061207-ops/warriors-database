
<?php
require_once 'config.php';

$nombreJoueurs = $pdo->query(
    'SELECT COUNT(*) FROM joueurs'
)->fetchColumn();

$nombreTitres = $pdo->query(
    'SELECT COUNT(*) FROM titres'
)->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warriors Database - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="entete">
    <a class="logo" href="index.php">
        <img src="images/logo-warriors.png" alt="Logo Golden State Warriors">
        <span>Warriors Database</span>
    </a>
    <nav aria-label="Navigation principale">
        <a href="index.php">Accueil</a>
        <a href="joueurs.php">Joueurs</a>
        <a href="palmares.php">Palmarès</a>
    </nav>
</header>

<main>
    <section class="hero">
        <span class="etiquette">PROJET PHP / MYSQL</span>
        <h1>Golden State Warriors</h1>
        <p>
            Découvrez l'histoire, les joueurs emblématiques
            et le palmarès d'une franchise légendaire de la NBA.
        </p>

        <div class="actions">
            <a class="bouton" href="joueurs.php">
                Découvrir les joueurs
            </a>
            <a class="bouton secondaire" href="palmares.php">
                Voir les titres
            </a>
        </div>
    </section>

    <section class="conteneur">
        <h2>La franchise en quelques chiffres</h2>

        <div class="grille chiffres">
            <article class="carte">
                <strong><?= e($nombreTitres) ?></strong>
                <h3>Titres NBA</h3>
                <p>Championnats remportés par la franchise.</p>
            </article>

            <article class="carte">
                <strong><?= e($nombreJoueurs) ?></strong>
                <h3>Joueurs présentés</h3>
                <p>Une sélection de joueurs historiques.</p>
            </article>

            <article class="carte">
                <strong>1946</strong>
                <h3>Création</h3>
                <p>Les débuts de la franchise NBA.</p>
            </article>
        </div>
    </section>

    <section class="conteneur">
        <div class="carte presentation">
            <h2>À propos de ce projet</h2>
            <p>
                Warriors Database est un projet personnel
                réalisé dans le cadre de mon apprentissage
                du développement web en BTS SIO SLAM.
            </p>
            <p>
                Il utilise HTML, CSS, PHP et MySQL.
                Les données présentées sur les joueurs
                et les titres sont récupérées depuis
                une base de données relationnelle.
            </p>
            <p>
                Il s'agit d'un site non officiel,
                créé à des fins pédagogiques.
            </p>
        </div>
    </section>
</main>

<footer>
    Projet personnel BTS SIO SLAM -
    Site non officiel des Golden State Warriors
</footer>

</body>
</html>
