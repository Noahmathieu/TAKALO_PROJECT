<?php
namespace App\Models;
class RechercheModel {
    	private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function searchItems($query, $categorie = '')
    {
        $search = '%' . $query . '%';

        if ($categorie === '' || $categorie === null) {
            $stmt = $this->db->prepare(
                "SELECT o.*, c.nom_categorie
                 FROM objet o
                 LEFT JOIN categorie c ON o.id_categorie = c.id_categorie
                 WHERE o.nom_objet LIKE :query OR o.description_objet LIKE :query"
            );
            $stmt->execute(['query' => $search]);
        } else {
            $stmt = $this->db->prepare(
                "SELECT o.*, c.nom_categorie
                 FROM objet o
                 LEFT JOIN categorie c ON o.id_categorie = c.id_categorie
                 WHERE (o.nom_objet LIKE :query OR o.description_objet LIKE :query)
                   AND o.id_categorie = :categorie"
            );
            $stmt->execute(['query' => $search, 'categorie' => $categorie]);
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getCategories()
    {
        $stmt = $this->db->query("SELECT * FROM categorie");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}