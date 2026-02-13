<?php
function e_stat($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
$total   = (int)($totalEchanges ?? 0);
$success = (int)($totalEchangeSuccess ?? 0);
$pending = (int)($totalEchangePending ?? 0);
$failed  = (int)($totalEchangeFailed ?? 0);

$pctSuccess = $total > 0 ? round($success / $total * 100) : 0;
$pctPending = $total > 0 ? round($pending / $total * 100) : 0;
$pctFailed  = $total > 0 ? round($failed  / $total * 100) : 0;

$pageTitle = 'Statistiques';
$extraCss  = ['/css/style_statistics.css'];
include __DIR__ . '/../partials/header.php';
?>

<div class="container py-4">

  <!-- Cartes statistiques -->
  <div class="row g-4 mb-4">

    <!-- Total Utilisateurs -->
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm h-100">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="stat-icon stat-icon-users text-white">👥</div>
          <div>
            <div class="stat-value"><?= e_stat($totalUsers ?? 0) ?></div>
            <div class="stat-label">Utilisateurs</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Échanges -->
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm h-100">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="stat-icon stat-icon-exchanges text-white">🔄</div>
          <div>
            <div class="stat-value"><?= e_stat($total) ?></div>
            <div class="stat-label">Échanges totaux</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Échanges Réussis -->
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm h-100">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="stat-icon stat-icon-success text-white">✅</div>
          <div>
            <div class="stat-value"><?= e_stat($success) ?></div>
            <div class="stat-label">Réussis</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Échanges Échoués -->
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm h-100">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="stat-icon stat-icon-failed text-white">❌</div>
          <div>
            <div class="stat-value"><?= e_stat($failed) ?></div>
            <div class="stat-label">Échoués</div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="row g-4">

    <!-- Répartition des échanges -->
    <div class="col-lg-7">
      <div class="card section-card shadow-sm">
        <div class="card-body">
          <h5 class="card-title fw-bold mb-4">Répartition des échanges</h5>

          <?php if ($total > 0): ?>

          <!-- Barre empilée visuelle -->
          <div class="chart-bar mb-4">
            <div class="d-flex h-100">
              <div class="chart-bar-fill chart-bar-fill-success" style="width:<?= $pctSuccess ?>%;" title="Réussis"></div>
              <div class="chart-bar-fill chart-bar-fill-pending" style="width:<?= $pctPending ?>%;" title="En attente"></div>
              <div class="chart-bar-fill chart-bar-fill-failed" style="width:<?= $pctFailed ?>%;" title="Échoués"></div>
            </div>
          </div>

          <!-- Détails par statut -->
          <div class="row text-center g-3">
            <div class="col-4">
              <div class="p-3 rounded-3 detail-box-success">
                <span class="badge-dot badge-dot-success"></span>
                <span class="fw-semibold text-success">Réussis</span>
                <div class="stat-value detail-value-success mt-2"><?= e_stat($success) ?></div>
                <small class="text-muted"><?= $pctSuccess ?>%</small>
              </div>
            </div>
            <div class="col-4">
              <div class="p-3 rounded-3 detail-box-pending">
                <span class="badge-dot badge-dot-pending"></span>
                <span class="fw-semibold text-pending">En attente</span>
                <div class="stat-value detail-value-pending mt-2"><?= e_stat($pending) ?></div>
                <small class="text-muted"><?= $pctPending ?>%</small>
              </div>
            </div>
            <div class="col-4">
              <div class="p-3 rounded-3 detail-box-failed">
                <span class="badge-dot badge-dot-failed"></span>
                <span class="fw-semibold text-danger">Échoués</span>
                <div class="stat-value detail-value-failed mt-2"><?= e_stat($failed) ?></div>
                <small class="text-muted"><?= $pctFailed ?>%</small>
              </div>
            </div>
          </div>

          <?php else: ?>
            <div class="text-center text-muted py-5">
              <div class="empty-state-icon">📭</div>
              <p class="mt-2 mb-0">Aucun échange enregistré pour le moment.</p>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>

    <!-- Résumé rapide -->
    <div class="col-lg-5">
      <div class="card section-card shadow-sm">
        <div class="card-body">
          <h5 class="card-title fw-bold mb-4">Résumé</h5>

          <table class="table table-borderless table-exchanges mb-0">
            <tbody>
              <tr>
                <td>
                  <span class="badge-dot badge-dot-users"></span>
                  Utilisateurs inscrits
                </td>
                <td class="text-end fw-bold"><?= e_stat($totalUsers ?? 0) ?></td>
              </tr>
              <tr>
                <td>
                  <span class="badge-dot badge-dot-exchanges"></span>
                  Total des échanges
                </td>
                <td class="text-end fw-bold"><?= e_stat($total) ?></td>
              </tr>
              <tr>
                <td>
                  <span class="badge-dot badge-dot-success"></span>
                  Échanges réussis
                </td>
                <td class="text-end">
                  <span class="badge bg-success bg-opacity-10 text-success"><?= e_stat($success) ?> (<?= $pctSuccess ?>%)</span>
                </td>
              </tr>
              <tr>
                <td>
                  <span class="badge-dot badge-dot-pending"></span>
                  Échanges en attente
                </td>
                <td class="text-end">
                  <span class="badge bg-warning bg-opacity-10 text-warning"><?= e_stat($pending) ?> (<?= $pctPending ?>%)</span>
                </td>
              </tr>
              <tr>
                <td>
                  <span class="badge-dot badge-dot-failed"></span>
                  Échanges échoués
                </td>
                <td class="text-end">
                  <span class="badge bg-danger bg-opacity-10 text-danger"><?= e_stat($failed) ?> (<?= $pctFailed ?>%)</span>
                </td>
              </tr>
            </tbody>
          </table>

          <?php if ($total > 0): ?>
          <hr>
          <div class="d-flex justify-content-between small text-muted">
            <span>Taux de réussite</span>
            <span class="fw-bold text-success"><?= $pctSuccess ?>%</span>
          </div>
          <div class="progress progress-thin mt-2">
            <div class="progress-bar bg-success" style="width: <?= $pctSuccess ?>%;"></div>
          </div>
          <?php endif; ?>

        </div>
      </div>
    </div>

  </div>

<?php include __DIR__ . '/../partials/footer.php'; ?>