<?php

class ObjetController {

    // ========================================
    // CATÉGORIES
    // ========================================

    public static function get_categories() {
        return get_categories();
    }

    // ========================================
    // OBJETS - CRUD
    // ========================================

    public static function creer($nom, $description, $id_categorie, $id_user) {
        return create_objet($nom, $description, $id_categorie, $id_user);
    }

    public static function mes_objets($id_user) {
        return get_objets_by_user($id_user);
    }

    public static function voir($id_objet) {
        return get_objet_by_id($id_objet);
    }

    public static function modifier($id_objet, $nom, $description, $id_categorie) {
        return update_objet($id_objet, $nom, $description, $id_categorie);
    }

    public static function supprimer($id_objet) {
        return delete_objet($id_objet);
    }

    // ========================================
    // OBJETS - LISTE AUTRES UTILISATEURS
    // ========================================

    public static function liste() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }

        $objets = getAllOther((int) $_SESSION['user_id']);
        Flight::render('auth/listeObjet', ['objets' => $objets]);
    }

    // ========================================
    // PHOTOS
    // ========================================

    public static function ajouter_photo($id_objet, $photo_path) {
        return add_photo($id_objet, $photo_path);
    }

    public static function photos($id_objet) {
        return get_photos_by_objet($id_objet);
    }

    public static function supprimer_photo($id_photo) {
        return delete_photo($id_photo);
    }
}
