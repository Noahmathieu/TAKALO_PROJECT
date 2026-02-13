<?php
require_once __DIR__ . '/../models/RechercheModel.php';

class RechercheController {

  public static function showRecherche() {
    $request = Flight::request();

    // Lire depuis GET ou POST
    $q        = trim($request->query->q ?? $request->data->q ?? '');
    $categorie = trim($request->query->categorie ?? $request->data->categorie ?? '');

    $pdo = Flight::db();
    $rechercheModel = new RechercheModel($pdo);

    $results = [];
    if ($q !== '') {
      $results = $rechercheModel->searchItems($q, $categorie);
    }

    $categories = Flight::get('categories') ?? $rechercheModel->getCategories();

    Flight::render('recherche', [
      'results'     => $results,
      'categories'  => $categories,
      'selectedCat' => $categorie,
      'q'           => $q
    ]);
  }

}