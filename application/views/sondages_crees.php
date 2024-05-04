<h2>Sondages créés par <?= $nom. ' '.$prenom ?></h2>

<?php
$sondagesEnCours = [];
$sondagesClotures = [];

foreach ($sondages as $sondage) {
    if ($sondage->enCours) {
        $sondagesEnCours[] = $sondage;
    } else {
        $sondagesClotures[] = $sondage;
    }
}

usort($sondagesEnCours, function ($a, $b) {
    return strcasecmp($a->titre, $b->titre);
});

usort($sondagesClotures, function ($a, $b) {
    return strcasecmp($a->titre, $b->titre);
});
?>

<?php if (!empty($sondagesEnCours)) : ?>
    <h3>Sondages en cours :</h3>
    <ul>
        <?php foreach ($sondagesEnCours as $sondage) : ?>
            <li>
                <h3><?= $sondage->titre ?></h3>
                <p>Lieu : <?= $sondage->lieu ?></p>
                <p>Descriptif : <?= $sondage->descriptif ?></p>
                <p>En cours: Oui</p>
                <div>
                    <?= anchor("Sondage/partager/{$sondage->cle}", 'Partager le sondage', ['role' => 'button']) ?>
                    <?= anchor("Sondage/reponses/{$sondage->cle}", 'Voir les réponses', ['role' => 'button']) ?>
                    <?= anchor("Sondage/confirmerCloture/{$sondage->cle}", 'Clôturer le sondage', ['role' => 'button']) ?>
                    <?= anchor("Sondage/confirmerSuppression/{$sondage->cle}", 'Supprimer le sondage', ['role' => 'button']) ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($sondagesClotures)) : ?>
    <h3>Sondages clôturés :</h3>
    <ul>
        <?php foreach ($sondagesClotures as $sondage) : ?>
            <li>
                <h3><?= $sondage->titre ?></h3>
                <p>Lieu : <?= $sondage->lieu ?></p>
                <p>Descriptif : <?= $sondage->descriptif ?></p>
                <p>En cours: Non</p>
                <div>
                    <?= anchor("Sondage/reponses/{$sondage->cle}", 'Voir les réponses', ['role' => '(button)']) ?>
                    <?= anchor("Sondage/confirmerSuppression/{$sondage->cle}", 'Supprimer le sondage', ['role' => '(button)']) ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (empty($sondagesEnCours) && empty($sondagesClotures)) : ?>
    <p>Aucun sondage créé encore</p>
<?php endif; ?>
