<?php
class ObjetController {

    public static function liste() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        $pdo  = Flight::db();
        $repo = new ObjetRepository($pdo);
        $objets = $repo->getAllOther((int) $_SESSION['user_id']);
        Flight::render('auth/listeObjet', ['objets' => $objets]);
    }
}
