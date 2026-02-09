<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ObjetController.php';
require_once __DIR__ . '/controllers/StatistiqueController.php';
require_once __DIR__ . '/controllers/RechercheController.php';
require_once __DIR__ . '/services/Validator.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/repositories/ObjetRepository.php';

// ========================================
// ROUTES D'AUTHENTIFICATION
// ========================================

// Inscription
Flight::route('GET /register', ['AuthController', 'showRegister']);
Flight::route('POST /register', ['AuthController', 'postRegister']);
Flight::route('POST /api/validate/register', ['AuthController', 'validateRegisterAjax']);

// Connexion
Flight::route('GET /login', ['AuthController', 'showLogin']);
Flight::route('POST /login', ['AuthController', 'postLogin']);
Flight::route('POST /api/validate/login', ['AuthController', 'validateLoginAjax']);

// Déconnexion
Flight::route('GET /logout', function(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    session_destroy();
    Flight::redirect('/login');
});

// Liste des objets des autres utilisateurs
Flight::route('GET /objets', ['ObjetController', 'liste']);

Flight::route('GET /mes-objets', function(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user_id'])) {
        Flight::redirect('/login');
        return;
    }
    $objets = ObjetController::mes_objets($_SESSION['user_id']);
    $categories = ObjetController::get_categories();
    
    Flight::render('objets/mes-objets', [
        'objets' => $objets,
        'categories' => $categories
    ]);
});


Flight::route('GET /api/objets', function(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user_id'])) {
        Flight::json(['error' => 'Non autorisé'], 401);
        return;
    }
    
    $objets = ObjetController::mes_objets($_SESSION['user_id']);
    Flight::json($objets);
});


Flight::route('GET /api/objets/@id', function($id){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user_id'])) {
        Flight::json(['error' => 'Non autorisé'], 401);
        return;
    }
    
    $objet = ObjetController::voir($id);
    if ($objet && $objet['id_user'] == $_SESSION['user_id']) {
        $objet['photos'] = ObjetController::photos($id);
        Flight::json($objet);
    } else {
        Flight::json(['error' => 'Objet non trouvé'], 404);
    }
});


Flight::route('POST /objets/add', function(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user_id'])) {
        Flight::redirect('/login');
        return;
    }
    
    $nom = trim($_POST['nom_objet'] ?? '');
    $description = trim($_POST['description_objet'] ?? '');
    $id_categorie = intval($_POST['id_categorie'] ?? 0);
    $id_user = $_SESSION['user_id'];
    

    $id_objet = ObjetController::creer($nom, $description, $id_categorie, $id_user);
    if (!empty($_FILES['photos']['name'][0])) {
        $upload_dir = __DIR__ . '/../public/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                $filename = uniqid() . '_' . basename($_FILES['photos']['name'][$key]);
                $filepath = $upload_dir . $filename;
                
                if (move_uploaded_file($tmp_name, $filepath)) {
                    ObjetController::ajouter_photo($id_objet, '/uploads/' . $filename);
                }
            }
        }
    }
    
    Flight::redirect('/mes-objets');
});

// Modifier un objet
Flight::route('POST /objets/edit', function(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user_id'])) {
        Flight::redirect('/login');
        return;
    }
    
    $id_objet = intval($_POST['id_objet'] ?? 0);
    $nom = trim($_POST['nom_objet'] ?? '');
    $description = trim($_POST['description_objet'] ?? '');
    $id_categorie = intval($_POST['id_categorie'] ?? 0);
    
    // Vérifier que l'objet appartient à l'utilisateur
    $objet = ObjetController::voir($id_objet);
    if (!$objet || $objet['id_user'] != $_SESSION['user_id']) {
        Flight::redirect('/mes-objets');
        return;
    }
    
    // Modifier l'objet
    ObjetController::modifier($id_objet, $nom, $description, $id_categorie);
    
    // Gérer les nouvelles photos
    if (!empty($_FILES['photos']['name'][0])) {
        $upload_dir = __DIR__ . '/../public/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                $filename = uniqid() . '_' . basename($_FILES['photos']['name'][$key]);
                $filepath = $upload_dir . $filename;
                
                if (move_uploaded_file($tmp_name, $filepath)) {
                    ObjetController::ajouter_photo($id_objet, '/uploads/' . $filename);
                }
            }
        }
    }
    
    Flight::redirect('/mes-objets');
});

// Supprimer un objet
Flight::route('POST /objets/delete', function(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user_id'])) {
        Flight::redirect('/login');
        return;
    }
    
    $id_objet = intval($_POST['id_objet'] ?? 0);
    $objet = ObjetController::voir($id_objet);
    if ($objet && $objet['id_user'] == $_SESSION['user_id']) {
     
        $photos = ObjetController::photos($id_objet);
        foreach ($photos as $photo) {
            $filepath = __DIR__ . '/../public' . $photo['photo_path'];
            if (file_exists($filepath)) {
                unlink($filepath);
            }
        }
        
        
        ObjetController::supprimer($id_objet);
    }
    
    Flight::redirect('/mes-objets');
});

// Supprimer une photo
Flight::route('POST /objets/delete-photo', function(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user_id'])) {
        Flight::json(['error' => 'Non autorisé'], 401);
        return;
    }
    
    $id_photo = intval($_POST['id_photo'] ?? 0);
    ObjetController::supprimer_photo($id_photo);
    
    Flight::json(['success' => true]);
});


Flight::route('GET /api/categories', function(){
    $categories = ObjetController::get_categories();
    Flight::json($categories);
});

// Statistiques
Flight::route('GET /statistique', ['StatistiqueController', 'showStatistique']);

// Recherche
Flight::route('GET /recherche', ['RechercheController', 'showRecherche']);
Flight::route('POST /recherche', ['RechercheController', 'showRecherche']);

Flight::route('POST /objets/echanger/@id', function($id){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user_id'])) {
        Flight::redirect('/login');
        return;
    }
    //demande
   
    Flight::redirect('/objets');
});