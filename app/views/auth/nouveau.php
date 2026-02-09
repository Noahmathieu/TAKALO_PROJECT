<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Bienvenue</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header text-center"><h4>Inscription terminée</h4></div>
        <div class="card-body text-center">
          <p class="lead">Merci — votre compte a été créé avec succès.</p>
          <p>Vous pouvez maintenant vous connecter.</p>
          <a class="btn btn-primary" href="/login">Se connecter</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
