<?php
$results = $results ?? [];
$q = $q ?? '';
$pageTitle = 'Recherche' . ($q ? ' — ' . htmlspecialchars($q, ENT_QUOTES, 'UTF-8') : '');
include __DIR__ . '/partials/header.php';
?>

<div class="container py-4">

  <?php if ($q !== ''): ?>
    <p class="text-muted mb-3">
      <?= count($results) ?> résultat(s) pour
      <strong>"<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>"</strong>
    </p>

    <?php if (!empty($results)): ?>
      <div class="row g-3">
        <?php foreach ($results as $objet): ?>
          <div class="col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius:.75rem;">
              <div class="card-body">
                <h6 class="card-title fw-bold mb-1">
                  <?= htmlspecialchars($objet['nom_objet'], ENT_QUOTES, 'UTF-8') ?>
                </h6>
                <?php if (!empty($objet['nom_categorie'])): ?>
                  <span class="badge bg-primary bg-opacity-10 text-primary mb-2">
                    <?= htmlspecialchars($objet['nom_categorie'], ENT_QUOTES, 'UTF-8') ?>
                  </span>
                <?php endif; ?>
                <p class="card-text text-muted small mb-0">
                  <?= htmlspecialchars(mb_strimwidth($objet['description_objet'] ?? '', 0, 120, '...'), ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center text-muted py-5">
        <div style="font-size:3rem;">🔍</div>
        <p class="mt-2 mb-0">Aucun objet trouvé pour cette recherche.</p>
      </div>
    <?php endif; ?>

  <?php endif; ?>

</div>

<?php include __DIR__ . '/partials/footer.php'; ?>