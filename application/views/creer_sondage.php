<h2>Créer un sondage</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('sondage/creer'); ?>

<label>Titre:</label>
<input type="text" name="titre" value="<?php echo set_value('titre'); ?>">
<br>

<label>Lieu:</label>
<input type="text" name="lieu" value="<?php echo set_value('lieu'); ?>">
<br>

<label>Descriptif:</label>
<textarea name="descriptif"><?php echo set_value('descriptif'); ?></textarea>
<br>

<div id="dates-container">
    <div class="date-input">
        <label>Date:</label>
        <input type="datetime-local" class="date-input" name="dates[]">
    </div>
</div>

<button type="button" id="add">Ajouter une date</button>

<input type="submit" value="Créer le sondage">

<?php echo form_close(); ?>

<script>
document.getElementById('add').addEventListener('click', function() {
    var div = document.createElement('div');
    div.innerHTML = `
    <label for="date">
    Date
    <input type="datetime-local" class="date-input" name="dates[]" value="<?=set_value('dates[]')?>" required>
    <button type="button" class="remove">Supprimer la date</button>
    </label>
    `;
    var addButton = document.getElementById('add');
    addButton.parentNode.insertBefore(div, addButton);
});

document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('remove')) {
        e.target.parentNode.parentNode.remove();
    }
});
</script>