
<?php
require_once 'config.php';

$requete = $pdo->query(
    'SELECT * FROM joueurs ORDER BY id ASC'
);

$joueurs = $requete->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Les joueurs - Warriors Database</title>
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

<main class="conteneur">
    <div class="intro-page">
        <span class="etiquette">LES LÉGENDES</span>
        <h1>Les joueurs emblématiques</h1>
        <p>
            Découvrez une sélection de joueurs ayant
            marqué l'histoire des Golden State Warriors.
        </p>
    </div>

    <div class="grille joueurs">
        <?php foreach ($joueurs as $joueur): ?>
            <article class="carte carte-joueur">
                <a href="joueur.php?id=<?= (int)$joueur['id'] ?>"
                class="lien-fiche-joueur">

                <?php
                $photo = $joueur['photo'];
                $photoValide = preg_match(
                    '/^[a-zA-Z0-9_-]+\.jpg$/',
                    $photo
                );
                $chemin = 'images/' . $photo;
                ?>

                <?php if (
                    $photoValide &&
                    is_file(__DIR__ . '/' . $chemin)
                ): ?>
                    <img
                        src="<?= e($chemin) ?>"
                        alt="Photo de <?= e($joueur['nom']) ?>"
                        loading="lazy">
                <?php else: ?>
                    <div class="image-manquante">
                        🏀
                    </div>
                <?php endif; ?>

                <div class="contenu-carte">
                    <span class="numero">
                        #<?= e($joueur['numero']) ?>
                    </span>

                    <h2><?= e($joueur['nom']) ?></h2>

                    <p class="poste">
                        <?= e($joueur['poste']) ?>
                    </p>

                    <p>
                        <strong>Période :</strong>
                        <?= e($joueur['periode']) ?>
                    </p>

                    <p>
                        <?= e($joueur['description']) ?>
                    </p>
                </div>

                    <span class="texte-decouvrir">
                        Voir sa fiche complète →
                    </span>
                </a>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if (empty($joueurs)): ?>
        <p>Aucun joueur enregistré pour le moment.</p>
    <?php endif; ?>
</main>

<footer>
    Warriors Database - Projet personnel BTS SIO SLAM
</footer>

</body>
</html>
