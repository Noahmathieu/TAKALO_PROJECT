<?php
function get_pdo() {
    return Flight::db();
}

function create_objet($nom, $description, $id_categorie, $id_user) {
    $pdo = get_pdo();
    
    $sql = "INSERT INTO objet (nom_objet, description_objet, id_categorie, id_user) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $description, $id_categorie, $id_user]);
    
    return $pdo->lastInsertId();
}


function get_objets_by_user($id_user) {
    $pdo = get_pdo();
    
    $sql = "SELECT o.*, c.nom_categorie 
            FROM objet o 
            LEFT JOIN categorie c ON o.id_categorie = c.id_categorie 
            WHERE o.id_user = ? 
            ORDER BY o.created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_user]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function get_objet_by_id($id_objet) {
    $pdo = get_pdo();
    
    $sql = "SELECT o.*, c.nom_categorie 
            FROM objet o 
            LEFT JOIN categorie c ON o.id_categorie = c.id_categorie 
            WHERE o.id_objet = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_objet]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function update_objet($id_objet, $nom, $description, $id_categorie) {
    $pdo = get_pdo();
    
    $sql = "UPDATE objet 
            SET nom_objet = ?, description_objet = ?, id_categorie = ? 
            WHERE id_objet = ?";
    
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute([$nom, $description, $id_categorie, $id_objet]);
}

function delete_objet($id_objet) {
    $pdo = get_pdo();
    
    $sql_photos = "DELETE FROM objet_photos WHERE objet_id = ?";
    $stmt_photos = $pdo->prepare($sql_photos);
    $stmt_photos->execute([$id_objet]);

    $sql = "DELETE FROM objet WHERE id_objet = ?";
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute([$id_objet]);
}

function get_categories() {
    $pdo = get_pdo();
    
    $sql = "SELECT * FROM categorie ORDER BY nom_categorie";
    $stmt = $pdo->query($sql);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function add_photo($id_objet, $photo_path) {
    $pdo = get_pdo();
    
    $sql = "INSERT INTO objet_photos (objet_id, photo_path) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute([$id_objet, $photo_path]);
}


function get_photos_by_objet($id_objet) {
    $pdo = get_pdo();
    
    $sql = "SELECT * FROM objet_photos WHERE objet_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_objet]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function delete_photo($id_photo) {
    $pdo = get_pdo();
    $sql = "DELETE FROM objet_photos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_photo]);
}
  function getAllOther($id_user) {
    $pdo = get_pdo();
    $sql = "SELECT * FROM objet WHERE id_user != ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_user]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}