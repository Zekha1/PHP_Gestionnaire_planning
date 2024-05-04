<h2>Tableau de toutes les réponses au sondage "<?php echo $sondage->titre; ?>"</h2>

<?php $rep = false; ?>
<?php foreach ($reponses as $reponse) { ?>
    <?php if ($reponse->nom) { ?>
        <?php $rep = true; ?>
        <?php break; ?>
    <?php } ?>
<?php } ?>

<?php if (!$rep) { ?>
    <p>Aucune réponse n'a été enregistrée pour ce sondage.</p>
<?php } else { ?>
    <?php $lastDateHeure = null; ?>
    <?php foreach ($dates as $date) { ?>
        <h3>Date : <?php echo $date->date; ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Noms des participants</th>
                    <th>Noms des non-participants</th>
                </tr>
            </thead>
            <tbody>
                <?php $idDate = $date->id; ?>
                <tr>
                    <?php if ($lastDateHeure !== $date->date) {?>
                        <?php $lastDateHeure = $date->date; ?>
                        <td>
                            <?php $participants = []; ?>
                            <?php $nonParticipants = []; ?>
                            <?php foreach ($reponses as $reponse) { ?>
                                <?php if ($reponse->date == $date->date) { ?>
                                    <?php $participants[$reponse->nom] = true; ?>
                                <?php } else { ?>
                                    <?php $nonParticipants[$reponse->nom] = true; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php echo implode(", ", array_keys($participants)); ?>
                        </td>
                        <td>
                            <?php $nonParticipants = array_diff_key($nonParticipants, $participants); ?>
                            <?php echo implode(", ", array_keys($nonParticipants)); ?>
                        </td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
    <?php } ?>
<?php } ?>

<br>
<div>
    <?=anchor('Sondage/reponses/'.$sondage->cle, "Retour aux meilleures possibilités", ['role' => 'button'])?>
    <?=anchor("Sondage/voirSondagesCrees", "Retour aux sondages créés", ['role' => 'button'])?>
</div>
