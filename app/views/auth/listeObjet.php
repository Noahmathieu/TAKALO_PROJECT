<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
$objets = $objets ?? [];
$mesObjets = $mesObjets ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Objets disponibles</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    .photo-preview { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; }
    .photo-small { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; margin: 2px; }
  </style>
</head>
<<<<<<< HEAD
<body>
    <h1>Liste des Objets</h1>
    <ul>
        <?php foreach ($objets as $objet){ ?>
            <li><?= $objet['nom_objet'] ?> </li>
            <li><?= $objet['description_objet'] ?> </li>
            <button><a href="/objets/echanger/<?= $objet['id_objet'] ?>">echanger</a></button>
            <button><a href="/history/<?= $objet['id_objet'] ?>">historique</a></button>
        <?php } ?>
    </ul>
=======
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/">Takalo</a>
    <div class="navbar-nav ms-auto">
      <a class="nav-link" href="/mes-objets"><i class="bi bi-box-seam"></i> Mes Objets</a>
      <span class="navbar-text me-3 ms-3">Bienvenue <?= e($_SESSION['user_username'] ?? 'Utilisateur') ?></span>
      <a class="btn btn-outline-light btn-sm" href="/logout">Déconnexion</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-shop"></i> Objets disponibles pour échange</h2>
  </div>

  <!-- Liste des objets des autres utilisateurs -->
  <div class="card">
    <div class="card-body">
      <?php if (empty($objets)){ ?>
        <div class="text-center py-5 text-muted">
          <i class="bi bi-inbox display-1"></i>
          <p class="mt-3">Aucun objet disponible pour le moment.</p>
        </div>
      <?php } else { ?>
        <table class="table table-hover">
          <thead class="table-dark">
            <tr>
              <th>Photo</th>
              <th>Nom</th>
              <th>Description</th>
              <th>Catégorie</th>
              <th>Propriétaire</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($objets as $objet){ ?>
              <tr>
                <td>
                  <?php 
                  $photos = get_photos_by_objet($objet['id_objet']);
                  if (!empty($photos)){ ?>
                    <img src="<?= e($photos[0]['photo_path']) ?>" class="photo-preview" alt="Photo">
                  <?php } else { ?>
                    <div class="photo-preview bg-secondary d-flex align-items-center justify-content-center text-white">
                      <i class="bi bi-image"></i>
                    </div>
                  <?php } ?>
                </td>
                <td><strong><?= e($objet['nom_objet']) ?></strong></td>
                <td><?= e(substr($objet['description_objet'] ?? '', 0, 50)) ?><?= strlen($objet['description_objet'] ?? '') > 50 ? '...' : '' ?></td>
                <td><span class="badge bg-info"><?= e($objet['nom_categorie'] ?? 'Non catégorisé') ?></span></td>
                <td><i class="bi bi-person"></i> <?= e($objet['username'] ?? 'Inconnu') ?></td>
                <td><small class="text-muted"><?= date('d/m/Y', strtotime($objet['created_at'])) ?></small></td>
                <td>
                  <?php if (!empty($mesObjets)){ ?>
                    <button class="btn btn-sm btn-outline-success btn-echange" 
                            data-id="<?= $objet['id_objet'] ?>"
                            data-nom="<?= e($objet['nom_objet']) ?>"
                            data-proprietaire="<?= e($objet['username'] ?? 'Inconnu') ?>">
                      <i class="bi bi-arrow-left-right"></i> Échanger
                    </button>
                  <?php } else { ?>
                    <span class="text-muted" title="Ajoutez d'abord un objet dans Mes Objets">
                      <i class="bi bi-info-circle"></i> Aucun objet à proposer
                    </span>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
    </div>
  </div>
</div>

<!-- Modal Demande d'échange -->
<div class="modal fade" id="echanteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="bi bi-arrow-left-right"></i> Demande d'échange</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="echanteForm" method="post" action="">
        <div class="modal-body">
          <div class="mb-3">
            <p>Vous souhaitez échanger contre l'objet : <strong id="echange_nom_objet"></strong></p>
            <p class="text-muted">Propriétaire : <span id="echange_proprietaire"></span></p>
          </div>
          <hr>
          <div class="mb-3">
            <label for="id_objet_offert" class="form-label">Choisissez un de vos objets à proposer en échange *</label>
            <select class="form-select" id="id_objet_offert" name="id_objet_offert" required>
              <option value="">-- Sélectionner un objet --</option>
              <?php foreach ($mesObjets as $monObjet){ ?>
                <option value="<?= $monObjet['id_objet'] ?>"><?= e($monObjet['nom_objet']) ?> (<?= e($monObjet['nom_categorie'] ?? 'Sans catégorie') ?>)</option>
              <?php } ?>
            </select>
          </div>
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> La demande sera envoyée au propriétaire. Il pourra l'accepter ou la refuser.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> Envoyer la demande</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Boutons Échanger
document.querySelectorAll('.btn-echange').forEach(btn => {
  btn.addEventListener('click', function() {
    const idObjet = this.dataset.id;
    const nomObjet = this.dataset.nom;
    const proprietaire = this.dataset.proprietaire;
    
    document.getElementById('echange_nom_objet').textContent = nomObjet;
    document.getElementById('echange_proprietaire').textContent = proprietaire;
    document.getElementById('echanteForm').action = '/objets/echanger/' + idObjet;
    document.getElementById('id_objet_offert').value = '';
    
    new bootstrap.Modal(document.getElementById('echanteModal')).show();
  });
});
</script>
>>>>>>> 7e4b49e0e9f39bd3aa552036f4ea112d36716416
</body>
</html>