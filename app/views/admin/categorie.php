<?php
$pageTitle = 'Gestion des Catégories — Takalo';
$extraCss  = ['/css/style_categorie.css'];
include __DIR__ . '/../partials/header.php';
?>

<!-- Page header -->
<div class="categorie-header">
  <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between">
    <div>
      <h1><i class="bi bi-tags-fill"></i> Gestion des Catégories</h1>
      <p>Ajoutez, modifiez ou supprimez les catégories d'objets</p>
    </div>
    <div class="mt-2 mt-md-0">
      <span class="stat-badge text-success">
        <i class="bi bi-collection"></i> <?= count($categories) ?> catégorie<?= count($categories) > 1 ? 's' : '' ?>
      </span>
    </div>
  </div>
</div>

<div class="container mb-5">
  <div class="row g-4">

    <!-- Formulaire d'ajout -->
    <div class="col-lg-4">
      <div class="card card-add-categorie">
        <div class="card-header">
          <i class="bi bi-plus-circle-fill"></i> Nouvelle catégorie
        </div>
        <div class="card-body">
          <form action="/admin/categorie/add" method="post">
            <div class="mb-3">
              <label for="nom_categorie" class="form-label">Nom</label>
              <input type="text" class="form-control" name="nom_categorie" id="nom_categorie"
                     placeholder="Ex : Électronique" required>
            </div>
            <div class="mb-3">
              <label for="description_categorie" class="form-label">Description</label>
              <textarea class="form-control" name="description_categorie" id="description_categorie"
                        rows="3" placeholder="Décrivez brièvement la catégorie…"></textarea>
            </div>
            <button type="submit" class="btn btn-add-categorie w-100">
              <i class="bi bi-plus-lg"></i> Ajouter
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Tableau des catégories -->
    <div class="col-lg-8">
      <div class="card card-table-categorie">
        <div class="card-header d-flex align-items-center justify-content-between">
          <span><i class="bi bi-list-ul"></i> Toutes les catégories</span>
        </div>
        <div class="card-body p-0">
          <?php if (empty($categories)): ?>
            <div class="empty-categories">
              <i class="bi bi-inbox"></i>
              <p>Aucune catégorie pour le moment.</p>
            </div>
          <?php else: ?>
          <div class="table-responsive">
            <table class="table table-categories mb-0">
              <thead>
                <tr>
                  <th style="width:60px">#</th>
                  <th>Nom</th>
                  <th>Description</th>
                  <th style="width:170px" class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($categories as $cat): ?>
                <form action="/admin/categorie/edit/<?= $cat['id_categorie'] ?>" method="post">
                  <tr>
                    <td data-label="#">
                      <span class="badge-id"><?= $cat['id_categorie'] ?></span>
                    </td>
                    <td data-label="Nom">
                      <input type="text" class="form-control form-control-sm"
                             name="nom_categorie"
                             value="<?= htmlspecialchars($cat['nom_categorie']) ?>">
                    </td>
                    <td data-label="Description">
                      <input type="text" class="form-control form-control-sm"
                             name="description_categorie"
                             value="<?= htmlspecialchars($cat['description_categorie'] ?? '') ?>">
                    </td>
                    <td data-label="Actions" class="actions-cell-cat text-center">
                      <button type="submit" class="btn btn-action-edit btn-sm" title="Modifier">
                        <i class="bi bi-pencil-square"></i> Modifier
                      </button>
                      <a href="/admin/categorie/delete/<?= $cat['id_categorie'] ?>"
                         class="btn-action-delete btn-sm"
                         onclick="return confirm('Supprimer cette catégorie ?');"
                         title="Supprimer">
                        <i class="bi bi-trash3"></i> Supprimer
                      </a>
                    </td>
                  </tr>
                </form>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>