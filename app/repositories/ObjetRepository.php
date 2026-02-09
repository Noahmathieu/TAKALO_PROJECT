<?php
class ObjetRepository {
    
  private $pdo;
  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function getAllOther($id_user) {
    $st = $this->pdo->prepare("SELECT * FROM objet WHERE id_user != :id_user");
    $st->execute(['id_user' => $id_user]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  
}

function create_objet($url , $name , $description , $category , $user_id){
  global $pdo;
  $st = $pdo->prepare("INSERT INTO objets (url, name, description, category, user_id) VALUES (?, ?, ?, ?, ?)");
  $st->execute([$url, $name, $description, $category, $user_id]);
  return $pdo->lastInsertId();
}

function insert_photo() {
    
}