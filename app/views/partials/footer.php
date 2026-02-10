</main>

<!-- Footer -->
<footer class="mt-auto py-3" style="background: #212529;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-4 text-center text-md-start mb-2 mb-md-0">
        <span class="text-light fw-bold"><i class="bi bi-arrow-left-right"></i> Takalo</span>
        <small class="text-secondary d-block">Plateforme d'échange d'objets</small>
      </div>
      <div class="col-md-4 text-center mb-2 mb-md-0">
        <small class="text-secondary">&copy; <?= date('Y') ?> Takalo — Tous droits réservés by: Noah & Mitia & Tommy</small>
      </div>
      <div class="col-md-4 text-center text-md-end">
        <a href="/objets" class="text-secondary text-decoration-none me-3"><small>Objets</small></a>
        <a href="/statistique" class="text-secondary text-decoration-none me-3"><small>Statistiques</small></a>
        <a href="/recherche" class="text-secondary text-decoration-none"><small>Recherche</small></a>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php if (!empty($extraJs)): ?>
  <?php foreach ((array)$extraJs as $js): ?>
    <script src="<?= $js ?>"></script>
  <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
