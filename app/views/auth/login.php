<?php
if (!function_exists('e')) { function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('cls_invalid')) { function cls_invalid($errors, $field){ return ($errors[$field] ?? '') !== '' ? 'is-invalid' : ''; } }
$pageTitle = 'Connexion';
include __DIR__ . '/../partials/header.php';
?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card">
        <div class="card-header text-center"><h4>Connexion</h4></div>
        <div class="card-body">

          <?php if (!empty($success)): ?>
            <div class="alert alert-success">Connexion réussie ✅</div>
          <?php endif; ?>

          <?php if (!empty($error_global)): ?>
            <div class="alert alert-danger"><?= e($error_global) ?></div>
          <?php endif; ?>

          <form id="loginForm" method="post" action="/login" novalidate>
            <div id="formStatus" class="alert d-none"></div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input id="email" name="email" type="email" class="form-control <?= cls_invalid($errors,'email') ?>" value="<?= e($values['email'] ?? '') ?>" placeholder="nom@exemple.com">
              <div class="invalid-feedback" id="emailError"><?= e($errors['email'] ?? '') ?></div>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Mot de passe</label>
              <input id="password" name="password" type="password" class="form-control <?= cls_invalid($errors,'password') ?>" placeholder="Votre mot de passe">
              <div class="invalid-feedback" id="passwordError"><?= e($errors['password'] ?? '') ?></div>
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="remember" name="remember">
              <label class="form-check-label" for="remember">Se souvenir de moi</label>
            </div>

            <button class="btn btn-primary w-100" type="submit">Se connecter</button>
          </form>

          <hr>
          <p class="text-center mb-0">
            Pas encore de compte ? <a href="/register">Créer un compte</a>
          </p>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
$extraJs = ['/js/validation-login.js'];
include __DIR__ . '/../partials/footer.php';
?>
