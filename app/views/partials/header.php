<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$_isLogged = !empty($_SESSION['user_id']);
$_username = htmlspecialchars($_SESSION['user_username'] ?? 'Utilisateur', ENT_QUOTES, 'UTF-8');
$_currentUri = $_SERVER['REQUEST_URI'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? 'Takalo' ?></title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/style_recherche.css">
  <link rel="stylesheet" href="/css/style_echange.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <?php if (!empty($extraCss)): ?>
    <?php foreach ((array)$extraCss as $css): ?>
      <link rel="stylesheet" href="<?= $css ?>">
    <?php endforeach; ?>
  <?php endif; ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<!-- Barre de recherche -->
<?php if ($_isLogged): ?>
  <?php include __DIR__ . '/search_bar.php'; ?>
<?php endif; ?>

<!-- Navbar principale -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #343a40 0%, #212529 100%); box-shadow: 0 2px 8px rgba(0,0,0,.15);">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/">
      <i class="bi bi-arrow-left-right"></i> Takalo
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMain">
      <?php if ($_isLogged): ?>
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?= str_starts_with($_currentUri, '/objets') && !str_starts_with($_currentUri, '/objets/') ? 'active' : '' ?>" href="/objets">
            <i class="bi bi-shop"></i> Objets
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= str_starts_with($_currentUri, '/mes-objets') ? 'active' : '' ?>" href="/mes-objets">
            <i class="bi bi-box-seam"></i> Mes Objets
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= str_starts_with($_currentUri, '/statistique') ? 'active' : '' ?>" href="/statistique">
            <i class="bi bi-bar-chart"></i> Statistiques
          </a>
        </li>

        <?php if (($_SESSION['user_username'] ?? '') === 'admin'): ?>
        <li class="nav-item">
          <a class="nav-link <?= str_starts_with($_currentUri, '/admin/categorie') ? 'active' : '' ?>" href="/admin/categorie">
            <i class="bi bi-list-task"></i> Gérer Catégories
          </a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link <?= str_starts_with($_currentUri, '/recherche') ? 'active' : '' ?>" href="/recherche">
            <i class="bi bi-search"></i> Recherche
          </a>
        </li>
      </ul>
      <div class="d-flex align-items-center">
        <span class="navbar-text me-3">
          <i class="bi bi-person-circle"></i> <?= $_username ?>
        </span>
        <a class="btn btn-outline-light btn-sm" href="/logout">
          <i class="bi bi-box-arrow-right"></i> Déconnexion
        </a>
      </div>
      <?php else: ?>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?= $_currentUri === '/login' ? 'active' : '' ?>" href="/login">
            <i class="bi bi-box-arrow-in-right"></i> Connexion
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $_currentUri === '/register' ? 'active' : '' ?>" href="/register">
            <i class="bi bi-person-plus"></i> Inscription
          </a>
        </li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>

<main class="flex-grow-1">
