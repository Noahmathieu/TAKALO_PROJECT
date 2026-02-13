<?php
$categories = $categories ?? Flight::get('categories') ?? [];
$q = htmlspecialchars($q ?? $_GET['q'] ?? '', ENT_QUOTES, 'UTF-8');
$selectedCat = $selectedCat ?? $_GET['categorie'] ?? '';
?>
<div class="search-bar">
  <div class="container">
    <form method="post" action="/recherche" class="d-flex align-items-center gap-2" enctype="multipart/form-data" >

      <!-- Input recherche -->
      <div class="search-input-wrapper flex-grow-1">
        <span class="search-icon">🔍</span>
        <input
          type="text"
          name="q"
          class="form-control search-input"
          placeholder="Rechercher un objet..."
          value="<?= $q ?>"
          autocomplete="off"
        >
      </div>

      <!-- Dropdown catégorie -->
      <select name="categorie" class="form-select category-select">
        <option value="">Toutes les catégories</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= (int)$cat['id_categorie'] ?>"
            <?= ($selectedCat == $cat['id_categorie']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['nom_categorie'], ENT_QUOTES, 'UTF-8') ?>
          </option>
        <?php endforeach; ?>
      </select>

      <!-- Bouton rechercher -->
      <button type="submit" class="btn btn-search">Rechercher</button>

    </form>
  </div>
</div>
