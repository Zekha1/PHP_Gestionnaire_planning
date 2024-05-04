<h2>Connexion</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('Utilisateur/connexion'); ?>

<label>Login:</label>
<input id='login' type="text" name="login" value="<?=set_value('login')?>">
<br>

<label>Mot de passe:</label>
<input id='password' type="password" name="password" value="<?=set_value('password')?>">
<br>

<input type="submit" value="Se connecter">
    
<?php echo form_close(); ?>