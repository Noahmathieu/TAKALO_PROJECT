<?php
if (!function_exists('e')) { function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); } }
$objets = $objets ?? [];
$categories = $categories ?? [];
$demandesRecues = $demandesRecues ?? [];
$pageTitle = 'Mes Objets';
include __DIR__ . '/../partials/header.php';
?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam"></i> Mes Objets</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addObjetModal">
      <i class="bi bi-plus-lg"></i> Ajouter un objet
    </button>
  </div>

  <!-- Liste des objets -->
  <div class="card">
    <div class="card-body">
      <?php if (empty($objets)): ?>
        <div class="text-center py-5 text-muted">
          <i class="bi bi-inbox display-1"></i>
          <p class="mt-3">Aucun objet pour le moment. Ajoutez votre premier objet !</p>
        </div>
      <?php else: ?>
        <table class="table table-hover">
          <thead class="table-dark">
            <tr>
              <th>Photo</th>
              <th>Nom</th>
              <th>Description</th>
              <th>Catégorie</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($objets as $objet): ?>
              <tr>
                <td>
                  <?php 
                  $photos = get_photos_by_objet($objet['id_objet']);
                  if (!empty($photos)): ?>
                    <img src="<?= e($photos[0]['photo_path']) ?>" class="photo-preview" alt="Photo">
                  <?php else: ?>
                    <div class="photo-preview bg-secondary d-flex align-items-center justify-content-center text-white">
                      <i class="bi bi-image"></i>
                    </div>
                  <?php endif; ?>
                </td>
                <td><strong><?= e($objet['nom_objet']) ?></strong></td>
                <td><?= e(substr($objet['description_objet'] ?? '', 0, 50)) ?><?= strlen($objet['description_objet'] ?? '') > 50 ? '...' : '' ?></td>
                <td><span class="badge bg-info"><?= e($objet['nom_categorie'] ?? 'Non catégorisé') ?></span></td>
                <td><small class="text-muted"><?= date('d/m/Y', strtotime($objet['created_at'])) ?></small></td>
                <td>
                  <?php 
                  $demandes = $demandesRecues[$objet['id_objet']] ?? [];
                  if (!empty($demandes)): ?>
                    <button class="btn btn-sm btn-warning btn-detail-demande"
                            data-id="<?= $objet['id_objet'] ?>"
                            data-nom="<?= e($objet['nom_objet']) ?>">
                      <i class="bi bi-envelope-fill"></i> <?= count($demandes) ?> demande<?= count($demandes) > 1 ? 's' : '' ?>
                    </button>
                  <?php endif; ?>
                  <button class="btn btn-sm btn-outline-primary btn-edit" 
                          data-id="<?= $objet['id_objet'] ?>"
                          data-nom="<?= e($objet['nom_objet']) ?>"
                          data-description="<?= e($objet['description_objet'] ?? '') ?>"
                          data-categorie="<?= $objet['id_categorie'] ?>">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-danger btn-delete" 
                          data-id="<?= $objet['id_objet'] ?>"
                          data-nom="<?= e($objet['nom_objet']) ?>">
                    <i class="bi bi-trash"></i>
                  </button>
                  <a href="/history/<?= $objet['id_objet'] ?>" class="btn btn-sm btn-outline-secondary" title="Historique">
                    <i class="bi bi-clock-history"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Modal Ajouter Objet -->
<div class="modal fade" id="addObjetModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Ajouter un objet</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="addObjetForm" method="post" action="/objets/add" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nom_objet" class="form-label">Nom de l'objet *</label>
            <input type="text" class="form-control" id="nom_objet" name="nom_objet" required>
          </div>
          <div class="mb-3">
            <label for="description_objet" class="form-label">Description</label>
            <textarea class="form-control" id="description_objet" name="description_objet" rows="3" placeholder="Décrivez votre objet..."></textarea>
          </div>
          <div class="mb-3">
            <label for="id_categorie" class="form-label">Catégorie</label>
            <select class="form-select" id="id_categorie" name="id_categorie">
              <option value="">-- Sélectionner une catégorie --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id_categorie'] ?>"><?= e($cat['nom_categorie']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="photos" class="form-label">Photos</label>
            <input type="file" class="form-control" id="photos" name="photos[]" multiple accept="image/*">
            <small class="text-muted">Vous pouvez sélectionner plusieurs photos</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Modifier Objet -->
<div class="modal fade" id="editObjetModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Modifier l'objet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editObjetForm" method="post" action="/objets/edit" enctype="multipart/form-data">
        <input type="hidden" id="edit_id_objet" name="id_objet">
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_nom_objet" class="form-label">Nom de l'objet *</label>
            <input type="text" class="form-control" id="edit_nom_objet" name="nom_objet" required>
          </div>
          <div class="mb-3">
            <label for="edit_description_objet" class="form-label">Description</label>
            <textarea class="form-control" id="edit_description_objet" name="description_objet" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="edit_id_categorie" class="form-label">Catégorie</label>
            <select class="form-select" id="edit_id_categorie" name="id_categorie">
              <option value="">-- Sélectionner une catégorie --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id_categorie'] ?>"><?= e($cat['nom_categorie']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_photos" class="form-label">Ajouter des photos</label>
            <input type="file" class="form-control" id="edit_photos" name="photos[]" multiple accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg"></i> Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteObjetModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Confirmer</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="post" action="/objets/delete">
        <input type="hidden" id="delete_id_objet" name="id_objet">
        <div class="modal-body text-center">
          <p>Voulez-vous vraiment supprimer<br><strong id="delete_nom_objet"></strong> ?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
          <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Oui, supprimer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Détail Demandes Reçues -->
<div class="modal fade" id="detailDemandeModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title"><i class="bi bi-envelope-open"></i> Demandes d'échange pour : <span id="detail_nom_objet"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detail_demandes_body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Données des demandes en JSON pour JS -->
<script type="application/json" id="demandes-data">
<?= json_encode($demandesRecues, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>
</script>

<?php
$extraJs = ['/js/mes-objets.js'];
include __DIR__ . '/../partials/footer.php';
?>
