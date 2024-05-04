<h2>Page d'accueil</h2>

<p>Bienvenue sur notre site de planification simplifiée !</p>

<p>Nous sommes ravis de vous revoir, <?= $prenom.' '.$nom; ?> ! 
    Grâce à nos fonctionnalités inspirées de Doodle, organiser des réunions et des rendez-vous n'a jamais été aussi facile.</p>

<p>Profitez de notre service convivial pour créer des sondages de disponibilité en un clin d'œil. Vous pouvez spécifier 
    les options de rendez-vous et partager le lien du sondage avec vos collègues, amis ou toute personne concernée. 
    Les participants pourront indiquer leurs disponibilités en sélectionnant les créneaux qui leur conviennent le mieux.</p>

<p>Nous sommes là pour simplifier votre vie et vous faire gagner du temps. Plus besoin de jongler avec les horaires et les agendas. 
    Notre communauté de planification simplifiée vous accompagne pour trouver le moment parfait pour vous rencontrer.</p>

<p>Profitez pleinement de notre service et découvrez à quel point la planification de réunions et de rendez-vous 
    peut être facile et agréable.</p>

<p>Bienvenue dans notre espace de planification simplifiée, où l'organisation est synonyme de simplicité et d'efficacité !</p>

<div>
    <?=anchor("Sondage/creer",'Nouveau sondage',['role'=>('button')])?>
    <?=anchor("Sondage/VoirSondagesCrees",'Voir mes sondages',['role'=>('button')])?>
</div>
