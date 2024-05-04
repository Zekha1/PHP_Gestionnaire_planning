<h2>Réponses au sondage <?php echo $sondage->titre; ?></h2>

<?php
$rep = 0;
foreach ($reponses as $reponse) {
    if ($reponse->nom) {
        $rep = 1;
    }
}

if ($rep === 0) {
    echo "<p>Aucune réponse n'a été enregistrée pour ce sondage.</p>";
} else {
    $maxParticipants = 0;
    foreach ($dates as $date) {
        $nombreParticipants = 0;
        foreach ($reponses as $reponse) {
            if ($reponse->date == $date->date && $reponse->nom) {
                $nombreParticipants++;
            }
        }
        if ($nombreParticipants > $maxParticipants) {
            $maxParticipants = $nombreParticipants;
        }
    }

    // Refaire le tour et afficher les maxParticipants
    echo "<p>Le(s) créneau(x) avec le plus de participants :</p>";
    echo "<ul>";
    $lastDateHeure = null;
    foreach ($dates as $date) {
        $nombreParticipants = 0;
        foreach ($reponses as $reponse) {
            if ($reponse->date == $date->date && $reponse->nom) {
                $nombreParticipants++;
            }
        }
        if ($nombreParticipants === $maxParticipants) {
            if ($lastDateHeure !== $date->date) {
                echo "<li>Date : " . $date->date."</li>";
                $lastDateHeure = $date->date;
            }
        }
    }
    echo "</ul>";
}
?>

<br>
<div>
    <?= anchor('Sondage/voirTableauSondage/'.$sondage->cle, "Voir le détail", ['role' => 'button']) ?>
    <?= anchor("Sondage/voirSondagesCrees", "Retour aux sondages créés", ['role' => 'button']) ?>
</div>
