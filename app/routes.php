<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/services/Validator.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/controllers/ObjetController.php';
require_once __DIR__ . '/repositories/ObjetRepository.php';

// Routes d'inscription
Flight::route('GET /register', ['AuthController', 'showRegister']);
Flight::route('POST /register', ['AuthController', 'postRegister']);
Flight::route('POST /api/validate/register', ['AuthController', 'validateRegisterAjax']);

// Routes de connexion
Flight::route('GET /login', ['AuthController', 'showLogin']);
Flight::route('POST /login', ['AuthController', 'postLogin']);
Flight::route('POST /api/validate/login', ['AuthController', 'validateLoginAjax']);

// Page après création
Flight::route('GET /nouveau', function(){
	Flight::render('auth/nouveau');
});

// Page de gestion des objets
Flight::route('GET /mes-objets', function(){
  if (session_status() === PHP_SESSION_NONE) session_start();
  if (empty($_SESSION['user_id'])) {
    Flight::redirect('/login');
    return;
  }
  Flight::render('objets/mes-objets');
});

// Déconnexion
Flight::route('GET /logout', function(){
  if (session_status() === PHP_SESSION_NONE) session_start();
  session_destroy();
  Flight::redirect('/login');
});








Flight::route('GET /objets', ['ObjetController', 'liste']);