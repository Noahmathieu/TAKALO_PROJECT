<?php
if (!function_exists('e')) { function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('cls_invalid')) { function cls_invalid($errors, $field){ return ($errors[$field] ?? '') !== '' ? 'is-invalid' : ''; } }
$pageTitle = 'Inscription';
include __DIR__ . '/../partials/header.php';
?>
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
            <button class="btn btn-primary w-100" type="submit">S'inscrire</button>
          </form>

          <hr>
          <p class="text-center mb-0">
            Déjà un compte ? <a href="/login">Se connecter</a>
          </p>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
$extraJs = ['/js/validation-ajax.js'];
include __DIR__ . '/../partials/footer.php';
?>
