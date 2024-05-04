<h2>Vos réponses envoyées</h2>

<table>
    <thead>
        <tr>
            <th>Date / Heure</th>
            <th>Réponse</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dates as $date) { ?>
            <tr>
                <td><?php echo $date->date; ?></td>
                <td>
                <?php
                    $reponse = 'non';
                    foreach ($reponses as $rep) {
                        if ($rep->sondage_date == $date->id) {
                            $reponse = 'oui';
                            break;
                        }
                    }
                    echo $reponse;
                ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<br>
<div>
    <?=anchor("SAE/accueil", "Retour à l'accueil", ['role' => ('button')])?>
    <?=anchor('Sondage/modifier_reponses/'. $sondage->cle.'/'.$nom, "Modifier", ['role' => ('button')]) ?>
</div>