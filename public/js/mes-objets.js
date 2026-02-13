// Boutons Modifier
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_id_objet').value = this.dataset.id;
        document.getElementById('edit_nom_objet').value = this.dataset.nom;
        document.getElementById('edit_description_objet').value = this.dataset.description;
        document.getElementById('edit_id_categorie').value = this.dataset.categorie;
        new bootstrap.Modal(document.getElementById('editObjetModal')).show();
    });
});

// Boutons Supprimer
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('delete_id_objet').value = this.dataset.id;
        document.getElementById('delete_nom_objet').textContent = this.dataset.nom;
        new bootstrap.Modal(document.getElementById('deleteObjetModal')).show();
    });
});

// Boutons Voir détail demandes
const demandesDataEl = document.getElementById('demandes-data');
if (demandesDataEl) {
    const demandesData = JSON.parse(demandesDataEl.textContent);
    document.querySelectorAll('.btn-detail-demande').forEach(btn => {
        btn.addEventListener('click', function() {
            const idObjet = this.dataset.id;
            const nomObjet = this.dataset.nom;

            document.getElementById('detail_nom_objet').textContent = nomObjet;

            const demandes = demandesData[idObjet] || [];
            let html = '';

            if (demandes.length === 0) {
                html = '<p class="text-muted text-center">Aucune demande.</p>';
            } else {
                demandes.forEach(d => {
                    html += `
            <div class="card mb-3 border-start border-4 border-warning">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <h6 class="card-title"><i class="bi bi-person"></i> ${d.demandeur_nom} veut échanger</h6>
                    <p class="mb-1">Propose : <strong>${d.nom_objet_offert}</strong></p>
                    <p class="mb-1">Contre votre : <strong>${d.nom_objet_demande}</strong></p>
                    <small class="text-muted">${new Date(d.created_at).toLocaleDateString('fr-FR')}</small>
                  </div>
                  <div class="d-flex gap-2">
                    <form method="post" action="/demande/accepter/${d.id_demande}" onsubmit="return confirm('Accepter cet échange ? Les propriétaires des deux objets seront échangés.')">
                      <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i> Accepter</button>
                    </form>
                    <form method="post" action="/demande/refuser/${d.id_demande}">
                      <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-x-lg"></i> Refuser</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          `;
                });
            }

            document.getElementById('detail_demandes_body').innerHTML = html;
            new bootstrap.Modal(document.getElementById('detailDemandeModal')).show();
        });
    });
}