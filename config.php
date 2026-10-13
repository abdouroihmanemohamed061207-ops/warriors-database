<?php
declare(strict_types=1);

$hote = 'localhost';
$base = 'warriors_db';
$utilisateur = 'root';
$motDePasse = ''; // Configuration WampServer locale habituelle

try {
    $pdo = new PDO(
        "mysql:host=$hote;dbname=$base;charset=utf8mb4",
        $utilisateur,
        $motDePasse,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Connexion à la base de données impossible.');
}

function e($valeur): string
{
    return htmlspecialchars(
        (string) $valeur,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}
