<?php

class CategorieModel{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getCategories()
    {
        $stmt = $this->db->query("SELECT * FROM categorie");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}