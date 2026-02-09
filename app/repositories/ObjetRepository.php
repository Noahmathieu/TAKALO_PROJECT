<?php


function create_objet($url , $name , $description , $category , $user_id){
  global $pdo;
  $st = $pdo->prepare("INSERT INTO objets (url, name, description, category, user_id) VALUES (?, ?, ?, ?, ?)");
  $st->execute([$url, $name, $description, $category, $user_id]);
  return $pdo->lastInsertId();
}

function insert_photo() {
    
}