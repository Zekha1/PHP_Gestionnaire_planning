<?php
class Sondage extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Sondage_model');
    }

    public function creer() {
        //vérifier que l'utilisateur est connecté
        if (!$this->session->userdata('login')) {
            redirect('utilisateur/connexion');
        }
        
        $data['user_id'] = $this->session->userdata('user_id');

        $this->form_validation->set_rules('titre', 'Titre', 'required');
        $this->form_validation->set_rules('lieu', 'Lieu', 'required');
        $this->form_validation->set_rules('descriptif', 'Descriptif', 'required');
        $this->form_validation->set_rules('dates[]', 'Dates', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Affichage du formulaire de création de sondage en cas d'erreur ou première visite
            $this->load->view('layout/header');
            $this->load->view('creer_sondage',$data);
            $this->load->view('layout/footer');

        } else {
            // Récupération des données du formulaire
            $data = array(
                'cle' => bin2hex(random_bytes(16)),
                'titre' => $this->input->post('titre'),
                'lieu' => $this->input->post('lieu'),
                'descriptif' => $this->input->post('descriptif'),
                'enCours' => TRUE,
                'auteur_id' => $this->session->userdata('user_id')
            );

            // Récupération des dates et heures du formulaire
            $dates = $this->input->post('dates');
    
            $sondage_cle = $this->Sondage_model->creerSondage($data, $dates);
    
            redirect('SAE/accueil');
        }
    }
    

    public function repondre($sondage_cle) {
        // Vérifier si le sondage existe
        $sondage = $this->Sondage_model->getSondageByKey($sondage_cle);
        if (!$sondage) {
            redirect('Sondage/sondage_introuvable');
        }

        // Vérifier si l'utilisateur est l'auteur du sondage
        if ($this->session->userdata('logged_in') || $this->session->userdata('user_id') === $sondage->auteur_id) {
            redirect('Sondage/own_sondage');

        }

        // Vérifier si le sondage est cloturé
        if (!$sondage->enCours) {
            redirect('Sondage/sondage_cloture');
        }
    
        // Récupérer les dates associées au sondage
        $dates = $this->Sondage_model->getDatesSondage($sondage_cle);

        // Règles de validation des champs du formulaire
        $this->form_validation->set_rules('nom', 'Nom', 'required');
    
        foreach ($dates as $date) {
           $this->form_validation->set_rules('disponibilites['.$date->id.']', 'Disponibilité', 'required');
        }
        
        if ($this->form_validation->run() === FALSE) {
            // Afficher le formulaire de réponse avec les erreurs de validation
            $data = array('sondage' => $sondage, 'dates' => $dates);
            if ($this->session->userdata('login')) {
                // Utilisateur connecté
                $data['nom'] = $this->session->userdata('nom');
            } else {
                $data['nom'] = '';
            }
            $this->load->view('layout/header');
            $this->load->view('repondre_sondage', $data);
            $this->load->view('layout/footer');

        } else {
            // Récupérer les données du formulaire
            $nom = $this->input->post('nom');
            $disponibilites = $this->input->post('disponibilites');

            foreach ($disponibilites as $date_id => $disponibilite) {
                // Vérifier si la disponibilité est "disponible"
                if ($disponibilite === "disponible") {
                    // Insérer la réponse dans la base de données
                    $this->Sondage_model->enregistrerReponse($nom, $sondage_cle, $date_id);
                }
            }            

            // Redirection vers la page des reponses envoyées
            redirect('Sondage/reponses_envoyees/'.$sondage_cle.'/'.$nom);
        }
    }
    
    public function reponses($sondage_cle) {
        // Récupérer le sondage par la clé
        $sondage = $this->Sondage_model->getSondageByKey($sondage_cle);
    
        // Récupérer les dates associées au sondage
        $dates = $this->Sondage_model->getDatesSondage($sondage_cle);
    
        // Récupérer les réponses associées au sondage
        $reponses = $this->Sondage_model->getReponsesSondage($sondage_cle);
    
        $data = array(
            'sondage' => $sondage,
            'dates' => $dates,
            'reponses' => $reponses
        );
    
        $this->load->view('layout/header');
        $this->load->view('reponses_sondage', $data);
        $this->load->view('layout/footer');
    }
      

    public function voirTableauSondage($sondage_cle) {
        // Récupérer le sondage par la clé
        $sondage = $this->Sondage_model->getSondageByKey($sondage_cle);
    
        // Récupérer les dates associées au sondage
        $dates = $this->Sondage_model->getDatesSondage($sondage_cle);
    
        // Récupérer les réponses associées au sondage
        $reponses = $this->Sondage_model->getReponsesSondage($sondage_cle);
    
        $data = array(
            'sondage' => $sondage,
            'dates' => $dates,
            'reponses' => $reponses
        );
    
        $this->load->view('layout/header');
        $this->load->view('tableau_reponses_sondage', $data);
        $this->load->view('layout/footer');
    }
    
    

    public function confirmerCloture($sondage_cle) {
        // Vérifier si l'utilisateur est l'auteur du sondage
        $sondage = $this->Sondage_model->getSondageByKey($sondage_cle);
        if (!$sondage || $sondage->auteur_id != $this->session->userdata('user_id')) {
            redirect('Sondage/autorisation_refusee');
        }
    
        // Charger la vue de confirmation de cloture
        $this->load->view('layout/header');
        $this->load->view('confirmation_cloture',['sondage_cle'=>$sondage_cle]);
        $this->load->view('layout/footer');
    }
    
    public function cloturer($sondage_cle) { 
        // Vérifier si l'utilisateur est l'auteur du sondage
        $sondage = $this->Sondage_model->getSondageByKey($sondage_cle);
        if (!$sondage || $sondage->auteur_id != $this->session->userdata('user_id')) {
            redirect('Sondage/autorisation_refusee');
        }

        // Clôturer le sondage
        $this->Sondage_model->cloturerSondage($sondage_cle);
    
        // Redirection vers la page des réponses
        redirect('Sondage/reponses/'.$sondage_cle);
    }

    public function voirSondagesCrees() {
        // Récupérer les informations de l'utilisateur connecté
        $nom = $this->session->userdata('nom');
        $prenom = $this->session->userdata('prenom');
        $user_id = $this->session->userdata('user_id');
    
        // Récupérer les sondages créés par l'utilisateur
        $sondages = $this->Sondage_model->getSondagesCreesParUtilisateur($user_id);
    
        // Passer les sondages et le login à la vue
        $data['sondages'] = $sondages;
        $data['nom'] = $nom;
        $data['prenom'] = $prenom;
    
        $this->load->view('layout/header');
        $this->load->view('sondages_crees', $data);
        $this->load->view('layout/footer');
    }    

    public function confirmerSuppression($sondage_cle) {
        // Vérifier si l'utilisateur est l'auteur du sondage
        $sondage = $this->Sondage_model->getSondageByKey($sondage_cle);
        if (!$sondage || $sondage->auteur_id != $this->session->userdata('user_id')) {
            redirect('Sondage/autorisation_refusee');
        }
    
        // Charger la vue de confirmation de suppression
        $this->load->view('layout/header');
        $this->load->view('confirmation_suppression',['sondage_cle'=>$sondage_cle]);
        $this->load->view('layout/footer');
    }
    

    public function supprimer($sondage_cle) {
        // Vérifier si l'utilisateur est l'auteur du sondage
        $sondage = $this->Sondage_model->getSondageByKey($sondage_cle);
        if (!$sondage || $sondage->auteur_id != $this->session->userdata('user_id')) {
            redirect('Sondage/autorisation_refusee');
        }
        // Supprimer le sondage de la base de données
        $this->Sondage_model->supprimerSondage($sondage_cle);
    
        // Redirection vers la page des sondages créés
        redirect('Sondage/voirSondagesCrees');
    }

    public function partager($sondage_cle) {
        // Récupérer le lien du sondage
        $lien_sondage = 'https://dwarves.iut-fbleau.fr/~bousson/CodeIgniter/index.php/sondage/repondre/'.$sondage_cle;
    
        // Charger la vue et passer le lien du sondage
        $data['lien_sondage'] = $lien_sondage;

        $this->load->view('layout/header');
        $this->load->view('partager_sondage', $data);
        $this->load->view('layout/footer');
    }

    public function reponses_envoyees($sondage_cle, $nom) {
        // Récupérer le sondage par la clé
        $sondage = $this->Sondage_model->getSondageByKey($sondage_cle);
    
        // Récupérer les dates associées au sondage
        $dates = $this->Sondage_model->getDatesSondage($sondage_cle);
    
        // Récupérer les réponses envoyées par l'utilisateur
        $reponses = $this->Sondage_model->getReponsesUtilisateur($sondage_cle, $nom);
    
        $data = array(
            'sondage' => $sondage,
            'dates' => $dates,
            'reponses' => $reponses,
            'nom' => $nom
        );
    
        $this->load->view('layout/header');
        $this->load->view('reponses_envoyees', $data);
        $this->load->view('layout/footer');
    }

    public function modifier_reponses($sondage_cle, $nom) {
        // Récupérer le sondage par la clé
        $sondage = $this->Sondage_model->getSondageByKey($sondage_cle);
    
        // Récupérer les dates associées au sondage
        $dates = $this->Sondage_model->getDatesSondage($sondage_cle);

        // Récupérer les réponses envoyées par l'utilisateur
        $reponses = $this->Sondage_model->getReponsesUtilisateur($sondage_cle, $nom);
    
        $data = array(
            'sondage' => $sondage,
            'dates' => $dates,
            'reponses' => $reponses,
            'nom' => $nom
        );
    
        // Supprimer les anciennes réponses de l'utilisateur
        $this->Sondage_model->supprimerReponses($sondage_cle, $nom);

        $this->load->view('layout/header');
        $this->load->view('repondre_sondage', $data);
        $this->load->view('layout/footer');
    }
    
    // Les erreurs
    public function own_sondage(){
        $this->load->view('layout/header');
        $this->load->view('erreurs/own_sondage');
        $this->load->view('layout/footer');
    }

    public function autorisation_refusee(){
        $this->load->view('layout/header');
        $this->load->view('erreurs/autorisation_refusee');
        $this->load->view('layout/footer');
    }

    public function sondage_cloture(){
        $this->load->view('layout/header');
        $this->load->view('erreurs/sondage_cloture');
        $this->load->view('layout/footer');
    }

    public function sondage_introuvable(){
        $this->load->view('layout/header');
        $this->load->view('erreurs/sondage_introuvable');
        $this->load->view('layout/footer');
    }
}
