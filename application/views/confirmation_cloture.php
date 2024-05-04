<h1>Confirmation de clôture</h1>

<div>
    <p>Êtes-vous sûr de vouloir clôturer ce sondage ?</p>
    <?=anchor('Sondage/cloturer/'.$sondage_cle,'Clôturer',['role'=>('button')])?>
    <?=anchor('Sondage/voirSondagesCrees','Annuler',['role'=>('button')])?>
</div>