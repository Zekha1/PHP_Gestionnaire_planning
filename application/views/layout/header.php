<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>SAE APP</title>
		<link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<?=link_tag('assets/style.css')?>
	</head>
	<body>
		<main class="container">
    	<div class="header">
			<?php if (!$this->session->userdata('login')) { ?>
            	<?=anchor("Utilisateur/connexion",'Connexion',['role'=>('button')])?>
    			<?=anchor("Utilisateur/inscription",'Inscription',['role'=>('button')])?>
        	<?php } else { ?>
				<?=anchor("Utilisateur/modifier",'Mon compte',['role'=>('button')])?>
				<?=anchor("Utilisateur/deconnexion",'Deconnexion',['role'=>('button')])?>
    	    <?php } ?>
		</div>