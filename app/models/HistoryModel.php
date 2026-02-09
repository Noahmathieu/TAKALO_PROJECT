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
            "SELECT e.*, u1.username AS user1, u2.username AS user2,
                    DATE_FORMAT(e.created_at, '%d/%m/%Y %H:%i') AS date_echange_formatted
             FROM demande_echange e
             JOIN users u1 ON e.id_demandeur = u1.id
             JOIN users u2 ON e.id_proprietaire = u2.id
             WHERE (e.id_objet_demande = :id_objet OR e.id_objet_offert = :id_objet2)
               AND e.statut = 'accepte'
             ORDER BY e.created_at DESC"
        );
        $stmt->execute(['id_objet' => $id_objet, 'id_objet2' => $id_objet]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } 
}