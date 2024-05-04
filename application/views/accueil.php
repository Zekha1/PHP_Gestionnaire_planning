<body>
    <div class="container">
        <h2>Page d'accueil</h2>
        
        <div class="float-right">
            <?php if (!$this->session->userdata('logged_in')) { ?>
                <?=anchor("Utilisateur/connexion",'Connexion',['role'=>('button')])?>
                <?=anchor("Utilisateur/inscription",'Inscription',['role'=>('button')])?>
            <?php } else { ?> <!--marche pas-->
                <?php echo $this->session->userdata('username'); ?>
                <?=anchor("Utilisateur/deconnexion",'Deconnexion',['role'=>('button')])?>
            <?php } ?>
        </div>
        
        <p>Contenu de la page d'accueil...</p>
    </div>
</body>
