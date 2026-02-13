<?php
require_once __DIR__ . '/../models/CategorieModel.php';
class CategorieController {

    public static function showCategorie() {
    $catModel = new CategorieModel(Flight::db());
        if (!self::requireAdmin()) {
            return;
        }
        $categories = $catModel->getCategories();
        Flight::render('admin/categorie', ['categories' => $categories]);
    }

    private static function requireAdmin(): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id']) || (($_SESSION['user_username'] ?? '') !== 'admin')) {
            Flight::redirect('/login');
            return false;
        }

        return true;
    }

    public static function edit($id) {
        if (!self::requireAdmin()) {
            return;
        }
        $nom_categorie = $_POST['nom_categorie'];
        $description_categorie = $_POST['description_categorie'];
        $pdo = Flight::db();
        $stmt = $pdo->prepare("UPDATE categorie SET nom_categorie = ?, description_categorie = ? WHERE id_categorie = ?");
        $stmt->execute([$nom_categorie, $description_categorie, $id]);
        Flight::redirect('/admin/categorie');

    }

    public static function delete($id) {
        if (!self::requireAdmin()) {
            return;
        }
        $pdo = Flight::db();
        $stmt = $pdo->prepare("DELETE FROM categorie WHERE id_categorie = ?");
        $stmt->execute([$id]);
        Flight::redirect('/admin/categorie');
    }

    public static function add() {
        if (!self::requireAdmin()) {
            return;
        }
        $nom_categorie = $_POST['nom_categorie'];
        $description_categorie = $_POST['description_categorie'];
        $pdo = Flight::db();
        $stmt = $pdo->prepare("INSERT INTO categorie (nom_categorie, description_categorie) VALUES (?, ?)");
        $stmt->execute([$nom_categorie, $description_categorie]);
        Flight::redirect('/admin/categorie');
    }
}