
<?php
require_once 'config.php';

$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);

if (!$id || $id < 1) {
    http_response_code(404);
    exit('Joueur introuvable.');
}

$requete = $pdo->prepare(
    'SELECT * FROM joueurs WHERE id = ?'
);
$requete->execute([$id]);

$joueur = $requete->fetch();

if (!$joueur) {
    http_response_code(404);
    exit('Joueur introuvable.');
}

// Calcul automatique de l'âge
$age = null;

if (!empty($joueur['date_naissance'])) {
    $naissance = new DateTimeImmutable(
        $joueur['date_naissance']
    );

    $reference = !empty($joueur['date_deces'])
        ? new DateTimeImmutable($joueur['date_deces'])
        : new DateTimeImmutable('today');

    $age = $naissance->diff($reference)->y;
}

// Photo principale
$photo = basename($joueur['photo']);
$cheminPhoto = 'images/' . $photo;

// Galerie des maillots : images/maillots/ID-*.jpg
$galerie = glob(
    __DIR__ . '/images/maillots/' . $id . '-*.jpg'
) ?: [];

sort($galerie);

// Franchises successives
$franchises = array_filter(
    array_map(
        'trim',
        explode('|', $joueur['franchises'] ?? '')
    )
);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>
        <?= e($joueur['nom']) ?> - Warriors Database
    </title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="entete">

    <a class="logo" href="index.php">
        <img src="images/logo-warriors.png"
             alt="Logo Warriors">
        <span>Warriors Database</span>
    </a>

    <nav aria-label="Navigation principale">
        <a href="index.php">Accueil</a>
        <a href="joueurs.php">Joueurs</a>
        <a href="palmares.php">Palmarès</a>
    </nav>

</header>

<main class="conteneur fiche-joueur">

    <a href="joueurs.php" class="retour-joueurs">
        ← Retour aux joueurs
    </a>

    <!-- PRÉSENTATION DU JOUEUR -->

    <section class="profil-joueur">

        <div class="photo-profil">

            <?php if (is_file(__DIR__ . '/' . $cheminPhoto)): ?>
                <img src="<?= e($cheminPhoto) ?>"
                     alt="Photo de <?= e($joueur['nom']) ?>">
            <?php else: ?>
                <div class="image-manquante">🏀</div>
            <?php endif; ?>

        </div>

        <div class="infos-profil">

            <span class="etiquette">
                LÉGENDE DES WARRIORS
            </span>

            <h1><?= e($joueur['nom']) ?></h1>

            <p class="poste-profil">
                #<?= e($joueur['numero']) ?>
                — <?= e($joueur['poste']) ?>
            </p>

            <span class="statut-joueur">
                <?= e($joueur['statut'] ?: 'Non renseigné') ?>
            </span>

            <div class="statistiques-joueur">

                <div>
                    <span>Taille</span>
                    <strong>
                        <?= $joueur['taille_cm']
                            ? e($joueur['taille_cm']) . ' cm'
                            : 'Non renseignée' ?>
                    </strong>
                </div>

                <div>
                    <span>
                        <?= $joueur['date_deces']
                            ? 'Âge au décès'
                            : 'Âge actuel' ?>
                    </span>
                    <strong>
                        <?= $age !== null
                            ? e($age) . ' ans'
                            : 'Non renseigné' ?>
                    </strong>
                </div>

                <div>
                    <span>Titres NBA</span>
                    <strong>
                        <?= e($joueur['titres_nba']) ?>
                    </strong>
                </div>

                <div>
                    <span>Numéro aux Warriors</span>
                    <strong>
                        #<?= e($joueur['numero']) ?>
                    </strong>
                </div>

            </div>

            <h2>Franchise actuelle</h2>

            <p>
                <?= $joueur['franchise_actuelle']
                    ? e($joueur['franchise_actuelle'])
                    : 'Aucune — carrière terminée' ?>
            </p>

            <h2>Biographie</h2>

            <p class="biographie-joueur">
                <?= e(
                    $joueur['biographie']
                    ?: $joueur['description']
                ) ?>
            </p>

        </div>

    </section>

    <!-- PARCOURS -->

    <section class="section-detail">

        <h2>Son parcours en NBA</h2>

        <div class="carte parcours-joueur">

            <?php foreach ($franchises as $franchise): ?>

                <div class="etape-carriere">
                    <span class="point-carriere"></span>
                    <p><?= e($franchise) ?></p>
                </div>

            <?php endforeach; ?>

        </div>

    </section>

    <!-- GALERIE DES MAILLOTS -->

    <section class="section-detail">

        <h2>Ses maillots au fil des saisons</h2>

        <p class="intro-maillots">
            Découvrez une sélection des maillots
            portés par ce joueur au cours
            de sa carrière.
        </p>

        <?php if (!empty($galerie)): ?>

            <div class="grille-maillots">

                <?php foreach ($galerie as $image): ?>

                    <div class="carte carte-maillot">

                        <img
                            src="images/maillots/<?= e(basename($image)) ?>"
                            alt="Maillot de <?= e($joueur['nom']) ?>"
                            loading="lazy">

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="carte maillots-attente">
                <p>
                    Les maillots de ce joueur
                    seront ajoutés prochainement.
                </p>
            </div>

        <?php endif; ?>

    </section>

</main>

<footer>
    Warriors Database —
    Projet personnel BTS SIO SLAM
</footer>

</body>
</html>
