<h2>Inscription</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('Utilisateur/inscription'); ?>

<label>Login:</label>
<input type="text" name="login" value="<?php echo set_value('login'); ?>">
<br>

<label>Mot de passe:</label>
<input type="password" name="password">
<br>

<label>Nom:</label>
<input type="text" name="nom" value="<?php echo set_value('nom'); ?>">
<br>

<label>Prénom:</label>
<input type="text" name="prenom" value="<?php echo set_value('prenom'); ?>">
<br>

<label>Email:</label>
<input type="email" name="email" value="<?php echo set_value('email'); ?>">
<br>

<input type="submit" value="S'inscrire">
    
<?php echo form_close(); ?>