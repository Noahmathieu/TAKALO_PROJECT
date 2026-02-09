<?php
namespace App\Models;
class StatisticsModel {
    	private $db;
	public function __construct($db)
	{
		$this->db = $db;
	}
    public function getTotalUsers()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM users");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'];
    }   
    public function getTotalEchanges()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM demande_echange");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'];
    }
    public  function getTotalEchangeSuccess(){
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM demande_echange WHERE statut = 'accepte'");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'];
    }
    public function getTotalEchangePending(){
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM demande_echange WHERE statut = 'en_attente'");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'];
    }
    public function getTotalEchangeFailed(){
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM demande_echange WHERE statut = 'refuse'");
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'];
    }

}