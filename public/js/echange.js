/**
 * Echange — Takalo
 * Gestion de la modal de demande d'échange
 */
document.addEventListener('DOMContentLoaded', function() {

    // Boutons "Échanger" → ouvre la modal
    document.querySelectorAll('.btn-echange').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var idObjet = this.dataset.id;
            var nomObjet = this.dataset.nom;
            var proprietaire = this.dataset.proprietaire;

            document.getElementById('echange_nom_objet').textContent = nomObjet;
            document.getElementById('echange_proprietaire').textContent = proprietaire;
            document.getElementById('echangeForm').action = '/objets/echanger/' + idObjet;

            // Reset sélection
            var select = document.getElementById('id_objet_offert');
            if (select) select.value = '';

            var modalEl = document.getElementById('echanteModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                new bootstrap.Modal(modalEl).show();
            }
        });
    });

});