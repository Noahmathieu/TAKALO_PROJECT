<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Objets</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/">Takalo</a>
    <div class="navbar-nav ms-auto">
      <span class="navbar-text me-3">Bienvenue <?= e($_SESSION['user_username'] ?? 'Utilisateur') ?></span>
      <a class="btn btn-outline-light btn-sm" href="/logout">Déconnexion</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Mes Objets</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addObjetModal">
      <i class="bi bi-plus"></i> Ajouter un objet
    </button>
  </div>

  <!-- Liste des objets -->
  <div class="card">
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Photo</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Catégorie</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="objetsTableBody">
          <!-- Les objets seront chargés ici -->
          <tr>
            <td colspan="5" class="text-center text-muted">Aucun objet pour le moment. Ajoutez votre premier objet !</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Ajouter Objet -->
<div class="modal fade" id="addObjetModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter un objet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="addObjetForm" method="post" action="/objets/add" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nom_objet" class="form-label">Nom de l'objet</label>
            <input type="text" class="form-control" id="nom_objet" name="nom_objet" required>
          </div>
          <div class="mb-3">
            <label for="description_objet" class="form-label">Description</label>
            <textarea class="form-control" id="description_objet" name="description_objet" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="id_categorie" class="form-label">Catégorie</label>
            <select class="form-select" id="id_categorie" name="id_categorie">
              <option value="">-- Sélectionner --</option>
              <!-- Les catégories seront chargées ici -->
            </select>
          </div>
          <div class="mb-3">
            <label for="photos" class="form-label">Photos</label>
            <input type="file" class="form-control" id="photos" name="photos[]" multiple accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Modifier Objet -->
<div class="modal fade" id="editObjetModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modifier l'objet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editObjetForm" method="post" action="/objets/edit" enctype="multipart/form-data">
        <input type="hidden" id="edit_id_objet" name="id_objet">
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_nom_objet" class="form-label">Nom de l'objet</label>
            <input type="text" class="form-control" id="edit_nom_objet" name="nom_objet" required>
          </div>
          <div class="mb-3">
            <label for="edit_description_objet" class="form-label">Description</label>
            <textarea class="form-control" id="edit_description_objet" name="description_objet" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="edit_id_categorie" class="form-label">Catégorie</label>
            <select class="form-select" id="edit_id_categorie" name="id_categorie">
              <option value="">-- Sélectionner --</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_photos" class="form-label">Nouvelles photos</label>
            <input type="file" class="form-control" id="edit_photos" name="photos[]" multiple accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
