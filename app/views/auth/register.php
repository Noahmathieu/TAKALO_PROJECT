<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function cls_invalid($errors, $field){ return ($errors[$field] ?? '') !== '' ? 'is-invalid' : ''; }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header text-center"><h4>Inscription utilisateur</h4></div>
        <div class="card-body">

          <?php if (!empty($success)): ?>
            <div class="alert alert-success">Inscription réussie ✅</div>
          <?php endif; ?>

          <form id="registerForm" method="post" action="/register" novalidate>
            <div id="formStatus" class="alert d-none"></div>

            <div class="mb-3">
              <label for="username" class="form-label">Nom d'utilisateur</label>
              <input id="username" name="username" type="text" class="form-control <?= cls_invalid($errors,'username') ?>" value="<?= e($values['username'] ?? '') ?>" placeholder="Votre nom d'utilisateur">
              <div class="invalid-feedback" id="usernameError"><?= e($errors['username'] ?? '') ?></div>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input id="email" name="email" type="email" class="form-control <?= cls_invalid($errors,'email') ?>" value="<?= e($values['email'] ?? '') ?>" placeholder="nom@exemple.com">
              <div class="invalid-feedback" id="emailError"><?= e($errors['email'] ?? '') ?></div>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Mot de passe</label>
              <input id="password" name="password" type="password" class="form-control <?= cls_invalid($errors,'password') ?>" placeholder="Minimum 8 caractères">
              <div class="invalid-feedback" id="passwordError"><?= e($errors['password'] ?? '') ?></div>
            </div>

            <div class="mb-3">
              <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
              <input id="confirm_password" name="confirm_password" type="password" class="form-control <?= cls_invalid($errors,'confirm_password') ?>" placeholder="Confirmez votre mot de passe">
              <div class="invalid-feedback" id="confirm_passwordError"><?= e($errors['confirm_password'] ?? '') ?></div>
            </div>

            <button class="btn btn-primary w-100" type="submit">S'inscrire</button>
          </form>

          <hr>
          <p class="text-center mb-0">
            Déjà un compte ? <a href="/login">Se connecter</a>
          </p>

          <script src="/js/validation-ajax.js" defer></script>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
