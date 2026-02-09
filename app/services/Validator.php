<?php
class Validator {

  public static function normalizeTelephone($tel) {
    return preg_replace('/\s+/', '', trim((string)$tel));
  }

  public static function validateRegister(array $input, UserRepository $repo = null) {
    $errors = [
      'username' => '', 'email' => '',
      'password' => '', 'confirm_password' => ''
    ];

    $values = [
      'username' => trim((string)($input['username'] ?? '')),
      'email' => trim((string)($input['email'] ?? '')),
    ];

    $password = (string)($input['password'] ?? '');
    $confirm  = (string)($input['confirm_password'] ?? '');

    // Validation du nom d'utilisateur
    if (mb_strlen($values['username']) < 3) {
      $errors['username'] = "Le nom d'utilisateur doit contenir au moins 3 caractères.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $values['username'])) {
      $errors['username'] = "Le nom d'utilisateur ne peut contenir que des lettres, chiffres et underscores.";
    }

    // Validation de l'email
    if ($values['email'] === '') {
      $errors['email'] = "L'email est obligatoire.";
    } elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "L'email n'est pas valide (ex: nom@domaine.com).";
    }

    // Validation du mot de passe
    if (strlen($password) < 8) {
      $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    // Validation de la confirmation
    if (strlen($confirm) < 1) {
      $errors['confirm_password'] = "Veuillez confirmer le mot de passe.";
    } elseif ($password !== $confirm) {
      $errors['confirm_password'] = "Les mots de passe ne correspondent pas.";
    }

    // Vérification unicité username
    if ($repo && $errors['username'] === '' && $repo->usernameExists($values['username'])) {
      $errors['username'] = "Ce nom d'utilisateur est déjà utilisé.";
    }

    // Vérification unicité email
    if ($repo && $errors['email'] === '' && $repo->emailExists($values['email'])) {
      $errors['email'] = "Cet email est déjà utilisé.";
    }

    $ok = true;
    foreach ($errors as $m) { if ($m !== '') { $ok = false; break; } }

    return ['ok' => $ok, 'errors' => $errors, 'values' => $values];
  }

  public static function validateLogin(array $input) {
    $errors = [
      'email' => '',
      'password' => ''
    ];

    $values = [
      'email' => trim((string)($input['email'] ?? '')),
    ];

    $password = (string)($input['password'] ?? '');

    // Validation de l'email
    if ($values['email'] === '') {
      $errors['email'] = "L'email est obligatoire.";
    } elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "L'email n'est pas valide (ex: nom@domaine.com).";
    }

    // Validation du mot de passe
    if (strlen($password) < 1) {
      $errors['password'] = "Le mot de passe est requis.";
    }

    $ok = true;
    foreach ($errors as $m) { if ($m !== '') { $ok = false; break; } }

    return ['ok' => $ok, 'errors' => $errors, 'values' => $values];
  }
}
