<?php
class UserRepository {
  private $pdo;
  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function emailExists($email) {
    $st = $this->pdo->prepare("SELECT 1 FROM users WHERE email=? LIMIT 1");
    $st->execute([(string)$email]);
    return (bool)$st->fetchColumn();
  }

  public function usernameExists($username) {
    $st = $this->pdo->prepare("SELECT 1 FROM users WHERE username=? LIMIT 1");
    $st->execute([(string)$username]);
    return (bool)$st->fetchColumn();
  }

  public function create($username, $email, $hash) {
    $st = $this->pdo->prepare("
      INSERT INTO users(username, email, password)
      VALUES(?,?,?)
    ");
    $st->execute([(string)$username, (string)$email, (string)$hash]);
    return $this->pdo->lastInsertId();
  }

  public function valide_user($email , $password_hash){
    $st = $this->pdo->prepare("SELECT * FROM users WHERE email=? AND password_hash=? LIMIT 1");
    $st->execute([(string)$email, (string)$password_hash]);
    return $st->fetch(PDO::FETCH_ASSOC);
  }

  public function findByEmail($email) {
    $st = $this->pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $st->execute([(string)$email]);
    return $st->fetch(PDO::FETCH_ASSOC);
  }
  
}
