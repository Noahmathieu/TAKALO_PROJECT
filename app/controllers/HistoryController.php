<?php
require_once __DIR__ . '/../models/HistoryModel.php';

class HistoryController {

  public static function showHistory($id_objet) {
    $pdo = Flight::db();
    $historyModel = new HistoryModel($pdo);
    $history = $historyModel->history($id_objet);
    Flight::render('history/history', ['history' => $history]);
  }

}