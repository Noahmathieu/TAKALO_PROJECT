<?php
class HistoryController {

  public static function showHistory($id_objet) {
    $pdo = Flight::db();
    $historyModel = new \App\Models\HistoryModel($pdo);
    $history = $historyModel->history($id_objet);
    Flight::render('history/history', ['history' => $history]);
  }

}