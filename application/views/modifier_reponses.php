<h2>Modifier vos réponses</h2>

<?php echo form_open('Sondage/enregistrer_modifications/'.$sondage->cle); ?>

<table>
    <thead>
        <tr>
            <th>Heure</th>
            <th>Réponse</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reponses as $reponse) { ?>
            <tr>
                <td><?php echo $reponse->date; ?></td>
                <td>
                    <input type="radio" name="reponses[<?php echo $reponse->id; ?>]" value="disponible" <?php if ($reponse->reponse == 'disponible') echo 'checked'; ?>>
                    <label>Disponible</label>
                    <input type="radio" name="reponses[<?php echo $reponse->id; ?>]" value="non_disponible" <?php if ($reponse->reponse == 'non_disponible') echo 'checked'; ?>>
                    <label>Non disponible</label>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<br>
<input type="submit" value="Enregistrer les modifications"> 

<?php echo form_close(); ?>