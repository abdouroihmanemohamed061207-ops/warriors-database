
<?php
require_once 'config.php';

// Récupération des titres depuis MySQL
$requete = $pdo->query(
    'SELECT * FROM titres ORDER BY annee DESC'
);

$titres = $requete->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Palmarès - Warriors Database</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="entete">

    <a class="logo" href="index.php">
        <img src="images/logo-warriors.png"
             alt="Logo Golden State Warriors">

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
        <span class="etiquette">
            HISTOIRE DE LA FRANCHISE
        </span>

        <h1>Le palmarès des Warriors</h1>

        <p>
            Découvrez les titres NBA remportés
            par les Golden State Warriors
            depuis la création de la franchise.
        </p>
    </div>

    <!-- GRILLE DES TITRES -->

    <div class="grille palmares">

        <?php foreach ($titres as $titre): ?>

            <article class="carte carte-titre">

                <!-- IMAGE DU TITRE -->

                <div class="image-titre">

                    <?php
                    $annee = (int) $titre['annee'];

                    $nomImage = "titre-$annee.jpg";
                    $cheminImage = "images/" . $nomImage;
                    ?>

                    <?php if (
                        is_file(__DIR__ . '/' . $cheminImage)
                    ): ?>

                        <img
                            src="<?= e($cheminImage) ?>"
                            alt="Warriors champions NBA en <?= e($annee) ?>"
                            loading="lazy">

                    <?php else: ?>

                        <div class="image-titre-attente">
                            🏆
                        </div>

                    <?php endif; ?>

                </div>

                <!-- INFORMATIONS -->

                <span class="etiquette">
                    CHAMPION NBA
                </span>

                <h2>
                    <?= e($titre['annee']) ?>
                </h2>

                <p>
                    <strong>Adversaire :</strong>
                    <?= e($titre['adversaire']) ?>
                </p>

                <p>
                    <strong>Résultat des finales :</strong>
                    <?= e($titre['resultat']) ?>
                </p>

                <!-- VIDÉO DE LA FINALE -->

                <?php
                $video = $titre['video_url'] ?? '';

                $hote = $video
                    ? strtolower(
                        parse_url($video, PHP_URL_HOST) ?? ''
                    )
                    : '';

                $videoValide =
                    filter_var($video, FILTER_VALIDATE_URL)
                    && in_array(
                        $hote,
                        [
                            'youtube.com',
                            'www.youtube.com',
                            'm.youtube.com',
                            'youtu.be'
                        ],
                        true
                    );
                ?>

                <div class="zone-video">

                    <?php if ($videoValide): ?>

                        <a
                            href="<?= e($video) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="bouton-video">

                            ▶ Revivre la finale

                        </a>

                    <?php else: ?>

                        <p class="video-attente">
                            Vidéo à venir
                        </p>

                    <?php endif; ?>

                </div>

            </article>

        <?php endforeach; ?>

    </div>

</main>

<footer>
    Warriors Database -
    Projet personnel BTS SIO SLAM
</footer>

</body>
</html>
