<?php
class StatistiqueController {

  public static function showStatistique() {
    $statisticsModel = new \App\Models\StatisticsModel(Flight::db());
    $totalUsers = $statisticsModel->getTotalUsers();
    $totalEchanges = $statisticsModel->getTotalEchanges();
    $totalEchangeSuccess = $statisticsModel->getTotalEchangeSuccess();
    $totalEchangePending = $statisticsModel->getTotalEchangePending();
    $totalEchangeFailed = $statisticsModel->getTotalEchangeFailed();
    Flight::render('statistics/statistique', [
      'totalUsers' => $totalUsers,
      'totalEchanges' => $totalEchanges,
      'totalEchangeSuccess' => $totalEchangeSuccess,
      'totalEchangePending' => $totalEchangePending,
      'totalEchangeFailed' => $totalEchangeFailed
    ]);
  }
    }