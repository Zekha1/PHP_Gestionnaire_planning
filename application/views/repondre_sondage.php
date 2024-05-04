<h2><?php echo $sondage->titre; ?></h2>
<p>Lieu : <?php echo $sondage->lieu; ?></p>
<p>Descriptif : <?php echo $sondage->descriptif; ?></p>

<?php echo form_open('Sondage/repondre/'.$sondage->cle); ?>
<?php if ($nom) { ?>
    <label>Connecté en tant que : </label>
    <input type="text" name="nom" value="<?php echo $nom; ?>">
<?php } else { ?>
    <label>Nom:</label>
    <input type="text" name="nom" value="">
    <br>
<?php } ?>

<h3>Disponibilité :</h3>

<?php foreach ($dates as $date) { ?>
    <label><?php echo $date->date; ?>:</label>
    <input type="radio" name="disponibilites[<?= $date->id ?>]" value="disponible" id="disponible_<?= $date->id ?>">
    <label for="disponible_<?= $date->id ?>">Disponible</label>
    <input type="radio" name="disponibilites[<?= $date->id ?>]" value="non_disponible" id="non_disponible_<?= $date->id ?>">
    <label for="non_disponible_<?= $date->id ?>">Non disponible</label>
    <br>
<?php } ?>

<br>
<input type="submit" value="Répondre au sondage">
<?php echo form_close(); ?>