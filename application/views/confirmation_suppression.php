<h1>Confirmation de suppression</h1>

<div>
    <p>Êtes-vous sûr de vouloir supprimer ce sondage ?</p>
    <?=anchor('Sondage/supprimer/'.$sondage_cle,'Supprimer',['role'=>('button')])?>
    <?=anchor('Sondage/voirSondagesCrees','Annuler',['role'=>('button')])?>
</div>