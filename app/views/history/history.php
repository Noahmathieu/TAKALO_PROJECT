<?php
function e_hist($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
$history = $history ?? [];
$pageTitle = 'Historique';
include __DIR__ . '/../partials/header.php';
?>

    <div class="container py-4">
        <h1 class="mb-4">Historique des propriétaires</h1>

        <?php if (empty($history)): ?>
            <div class="alert alert-info">Aucun historique disponible.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Propriétaire 1</th>
                            <th>Propriétaire 2</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $item): ?>
                            <tr>
                                <td><?= e_hist($item['user1'] ?? '') ?></td>
                                <td><?= e_hist($item['user2'] ?? '') ?></td>
                                <td><?= e_hist($item['date_echange_formatted'] ?? $item['date_echange'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
<?php include __DIR__ . '/../partials/footer.php'; ?>