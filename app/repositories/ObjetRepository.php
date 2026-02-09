<?php

if (!function_exists('get_pdo')) {
    function get_pdo() {
        return Flight::db();
    }
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
    $sql = "SELECT o.*, c.nom_categorie, u.username 
            FROM objet o 
            LEFT JOIN categorie c ON o.id_categorie = c.id_categorie
            LEFT JOIN users u ON o.id_user = u.id
            WHERE o.id_user != ?
            ORDER BY o.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_user]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ========================================
// DEMANDES D'ÉCHANGE
// ========================================

function create_demande_echange($id_objet_demande, $id_objet_offert, $id_demandeur, $id_proprietaire) {
    $pdo = get_pdo();
    $sql = "INSERT INTO demande_echange (id_objet_demande, id_objet_offert, id_demandeur, id_proprietaire) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_objet_demande, $id_objet_offert, $id_demandeur, $id_proprietaire]);
    return $pdo->lastInsertId();
}

function get_demandes_recues($id_proprietaire) {
    $pdo = get_pdo();
    $sql = "SELECT de.*, 
                   od.nom_objet AS nom_objet_demande, 
                   oo.nom_objet AS nom_objet_offert,
                   u.username AS demandeur_nom
            FROM demande_echange de
            JOIN objet od ON de.id_objet_demande = od.id_objet
            JOIN objet oo ON de.id_objet_offert = oo.id_objet
            JOIN users u ON de.id_demandeur = u.id
            WHERE de.id_proprietaire = ?
            ORDER BY de.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_proprietaire]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_demandes_envoyees($id_demandeur) {
    $pdo = get_pdo();
    $sql = "SELECT de.*, 
                   od.nom_objet AS nom_objet_demande, 
                   oo.nom_objet AS nom_objet_offert,
                   u.username AS proprietaire_nom
            FROM demande_echange de
            JOIN objet od ON de.id_objet_demande = od.id_objet
            JOIN objet oo ON de.id_objet_offert = oo.id_objet
            JOIN users u ON de.id_proprietaire = u.id
            WHERE de.id_demandeur = ?
            ORDER BY de.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_demandeur]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function update_statut_demande($id_demande, $statut) {
    $pdo = get_pdo();
    $sql = "UPDATE demande_echange SET statut = ? WHERE id_demande = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$statut, $id_demande]);
}

function get_demande_by_id($id_demande) {
    $pdo = get_pdo();
    $sql = "SELECT * FROM demande_echange WHERE id_demande = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_demande]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function demande_existe($id_objet_demande, $id_objet_offert, $id_demandeur) {
    $pdo = get_pdo();
    $sql = "SELECT COUNT(*) FROM demande_echange 
            WHERE id_objet_demande = ? AND id_objet_offert = ? AND id_demandeur = ? AND statut = 'en_attente'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_objet_demande, $id_objet_offert, $id_demandeur]);
    return $stmt->fetchColumn() > 0;
}

// Demandes envoyées par un user pour un objet précis (en_attente)
function get_demande_envoyee_pour_objet($id_objet_demande, $id_demandeur) {
    $pdo = get_pdo();
    $sql = "SELECT de.*, oo.nom_objet AS nom_objet_offert, u.username AS proprietaire_nom
            FROM demande_echange de
            JOIN objet oo ON de.id_objet_offert = oo.id_objet
            JOIN users u ON de.id_proprietaire = u.id
            WHERE de.id_objet_demande = ? AND de.id_demandeur = ? AND de.statut = 'en_attente'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_objet_demande, $id_demandeur]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Demandes reçues pour un objet précis (en_attente)
function get_demandes_recues_pour_objet($id_objet_demande, $id_proprietaire) {
    $pdo = get_pdo();
    $sql = "SELECT de.*, oo.nom_objet AS nom_objet_offert, od.nom_objet AS nom_objet_demande,
                   u.username AS demandeur_nom
            FROM demande_echange de
            JOIN objet oo ON de.id_objet_offert = oo.id_objet
            JOIN objet od ON de.id_objet_demande = od.id_objet
            JOIN users u ON de.id_demandeur = u.id
            WHERE de.id_objet_demande = ? AND de.id_proprietaire = ? AND de.statut = 'en_attente'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_objet_demande, $id_proprietaire]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function transferer_propriete($id_objet_demande, $id_objet_offert, $id_demandeur, $id_proprietaire) {
    $pdo = get_pdo();
    $pdo->beginTransaction();
    try {
        // L'objet demandé va au demandeur
        $sql1 = "UPDATE objet SET id_user = ? WHERE id_objet = ?";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([$id_demandeur, $id_objet_demande]);
        
        // L'objet offert va au propriétaire
        $sql2 = "UPDATE objet SET id_user = ? WHERE id_objet = ?";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$id_proprietaire, $id_objet_offert]);
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}