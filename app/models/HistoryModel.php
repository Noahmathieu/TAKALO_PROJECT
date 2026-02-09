<?php
namespace App\Models;
class HistoryModel {
    	private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function history($id_objet)
    {
        $stmt = $this->db->prepare(
            "SELECT e.*, u1.username AS user1, u2.username AS user2, date_format(e.date_echange, '%d/%m/%Y %H:%i') AS date_echange_formatted
             FROM echange e
             JOIN users u1 ON e.id_user1 = u1.id_user
             JOIN users u2 ON e.id_user2 = u2.id_user
             WHERE e.id_objet = :id_objet"
        );
        $stmt->execute(['id_objet' => $id_objet]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } 
}