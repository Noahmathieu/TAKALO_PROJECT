<?php

class ObjetController {

    // ========================================
    // CATÉGORIES
    // ========================================
    
    // Récupérer toutes les catégories
    public static function get_categories() {
        return get_categories();
    }

    // ========================================
    // OBJETS - CRUD
    // ========================================

    // Créer un nouvel objet
    public static function creer($nom, $description, $id_categorie, $id_user) {
        return create_objet($nom, $description, $id_categorie, $id_user);
    }

    // Lire tous les objets d'un utilisateur
    public static function mes_objets($id_user) {
        return get_objets_by_user($id_user);
    }

    // Lire un objet par son ID
    public static function voir($id_objet) {
        return get_objet_by_id($id_objet);
    }

    // Modifier un objet
    public static function modifier($id_objet, $nom, $description, $id_categorie) {
        return update_objet($id_objet, $nom, $description, $id_categorie);
    }

    // Supprimer un objet
    public static function supprimer($id_objet) {
        return delete_objet($id_objet);
    }

    // ========================================
    // PHOTOS
    // ========================================

    // Ajouter une photo
    public static function ajouter_photo($id_objet, $photo_path) {
        return add_photo($id_objet, $photo_path);
    }

    // Récupérer les photos d'un objet
    public static function photos($id_objet) {
        return get_photos_by_objet($id_objet);
    }

    // Supprimer une photo
    public static function supprimer_photo($id_photo) {
        return delete_photo($id_photo);
    }
}