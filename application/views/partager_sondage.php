<h2>Partager le sondage</h2>
<p>Cliquez sur le bouton pour copier le lien du sondage dans le presse-papiers :</p>
<input type="text" value="<?= $lien_sondage ?>" id="lien_sondage_input" readonly>
<button id='Bouton' onclick="copierLienSondage()">Copier le lien</button>

<script>
    function copierLienSondage() {
        var lienSondageInput = document.getElementById('lien_sondage_input');
        lienSondageInput.select();
        lienSondageInput.setSelectionRange(0, 99999); // Pour les navigateurs mobiles

        document.execCommand('copy');

        // Récupérer l'élément où afficher le message
        var messageElement = document.getElementById('Bouton');

        // Afficher le message
        messageElement.innerText = 'Copié';

        // Cacher le message après 2 secondes
        setTimeout(function() {
            messageElement.innerText = 'Copier le lien';
        }, 2000);
    }
</script>
