<?php
require_once __DIR__ . '/config.php';

Flight::register('db', 'PDO', array(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
    DB_USER,
    DB_PASS,
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    )
));

Flight::set('flight.views.path', __DIR__ . '/views');

// Charger les catégories globalement pour la barre de recherche
Flight::before('start', function () {
    $pdo = Flight::db();
    $stmt = $pdo->query("SELECT * FROM categorie");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Flight::set('categories', $categories);
});

require_once __DIR__ . '/routes.php';
