<h2>Modifier mes informations</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('utilisateur/modifier'); ?>

<label for="login">Login :</label>
<input type="text" name="login" value="<?php echo $login; ?>" required>

<label for="nom">Nom :</label>
<input type="text" name="nom" value="<?php echo $nom; ?>" required>

<label for="prenom">Prénom :</label>
<input type="text" name="prenom" value="<?php echo $prenom; ?>" required>

<label for="email">Email :</label>
<input type="email" name="email" value="<?php echo $email; ?>" required>

<label for="password">Mot de passe:</label>
<input type="password" name="password" value="">
<br>

<button type="submit">Enregistrer les modifications</button>

<?php echo form_close(); ?>