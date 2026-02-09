<?php
session_start();
class AuthController {

  public static function showRegister() {
    Flight::render('auth/register', [
      'values' => ['username'=>'', 'email'=>''],
      'errors' => ['username'=>'', 'email'=>'', 'password'=>''],
      'success' => false
    ]);
  }

  public static function showLogin() {
    Flight::render('auth/login', [
      'values' => ['email'=>''],
      'errors' => ['email'=>'','password'=>''],
      'success' => false,
      'error_global' => ''
    ]);
  }

  public static function validateRegisterAjax() {
    header('Content-Type: application/json; charset=utf-8');

    try {
      $req = Flight::request();
      $pdo  = Flight::db();
      $repo = new UserRepository($pdo);

      $input = [
        'username' => trim((string)$req->data->username),
        'email' => trim((string)$req->data->email),
        'password' => (string)$req->data->password,
      ];

      $res = Validator::validateRegister($input, $repo);

      Flight::json(['ok' => $res['ok'], 'errors' => $res['errors'], 'values' => $res['values']]);
    } catch (Throwable $e) {
      http_response_code(500);
      Flight::json([
        'ok' => false,
        'errors' => ['_global' => 'Erreur serveur lors de la validation.'],
        'values' => []
      ]);
    }
  }

  public static function postRegister() {
    $pdo  = Flight::db();
    $repo = new UserRepository($pdo);
    $svc  = new UserService($repo);

    $req = Flight::request();

    $input = [
      'username' => $req->data->username,
      'email' => $req->data->email,
      'password' => $req->data->password,
    ];

    $res = Validator::validateRegister($input, $repo);

    if ($res['ok']) {
      $svc->register($res['values'], (string)$input['password']);
      
      $user = $repo->findByEmail($res['values']['email']);
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_email'] = $user['email'];
      $_SESSION['user_username'] = $user['username'];      
      header('Location: /mes-objets');
      exit;
    }

    Flight::render('auth/register', [
      'values' => $res['values'],
      'errors' => $res['errors'],
      'success' => false
    ]);
  }

  public static function validateLoginAjax() {
    header('Content-Type: application/json; charset=utf-8');

    try {
      $req = Flight::request();

      $input = [
        'email' => trim((string)$req->data->email),
        'password' => (string)$req->data->password,
      ];

      $res = Validator::validateLogin($input);

      Flight::json(['ok' => $res['ok'], 'errors' => $res['errors'], 'values' => $res['values']]);
    } catch (Throwable $e) {
      http_response_code(500);
      Flight::json([
        'ok' => false,
        'errors' => ['_global' => 'Erreur serveur lors de la validation.'],
        'values' => []
      ]);
    }
  }

  public static function postLogin() {
    $pdo  = Flight::db();
    $repo = new UserRepository($pdo);

    $req = Flight::request();

    $input = [
      'email' => trim((string)$req->data->email),
      'password' => (string)$req->data->password,
    ];

    $res = Validator::validateLogin($input);

    if (!$res['ok']) {
      Flight::render('auth/login', [
        'values' => $res['values'],
        'errors' => $res['errors'],
        'success' => false,
        'error_global' => ''
      ]);
      return;
    }

    $user = $repo->findByEmail($input['email']);

    if (!$user || !password_verify($input['password'], $user['password'])) {
      Flight::render('auth/login', [
        'values' => $res['values'],
        'errors' => ['email' => '', 'password' => ''],
        'success' => false,
        'error_global' => 'Email ou mot de passe incorrect.'
      ]);
      return;
    }
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_username'] = $user['username'] ?? '';
    header('Location: /mes-objets');
    exit;
  }
}
