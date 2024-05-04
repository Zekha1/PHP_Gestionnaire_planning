<?php
class Utilisateur extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('utilisateur_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function inscription() {
        // Règles de validation des champs du formulaire
        $this->form_validation->set_rules('login', 'Login', 'required|is_unique[utilisateurs.login]');
        $this->form_validation->set_rules('password', 'Mot de passe', 'required');
        $this->form_validation->set_rules('nom', 'Nom', 'required');
        $this->form_validation->set_rules('prenom', 'Prénom', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() === FALSE) {
            // Affichage du formulaire d'inscription en cas d'erreur ou première visite
            $this->load->view('layout/header');
            $this->load->view('inscription');
            $this->load->view('layout/footer');
        } else {
            // Récupération des données du formulaire
            $data = array(
                'login' => $this->input->post('login'),
                'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom'),
                'email' => $this->input->post('email')
            );

            // Appel à la fonction du modèle pour créer un nouvel utilisateur
            $this->utilisateur_model->creerUtilisateur($data);

            // Redirection vers la page e connexion
            redirect('utilisateur/connexion');
        }
    }

    public function connexion() {
        // Règles de validation des champs du formulaire
        $this->form_validation->set_rules('login', 'Login', 'required');
        $this->form_validation->set_rules('password', 'Mot de passe', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            // Affichage du formulaire de connexion en cas d'erreur ou première visite
            $this->load->view('layout/header');
            $this->load->view('connexion');
            $this->load->view('layout/footer');
        } else {
            // Récupération des données du formulaire
            $login = $this->input->post('login');
            $password = $this->input->post('password');
            $utilisateur = $this->utilisateur_model->recupDonnees($login);
            $hash = $this->utilisateur_model->recupHash($login);
    
            if ($hash) {
                if (password_verify($password, $hash)) {
                    // Connecter l'utilisateur et rediriger vers une page d'accueil
                    $this->session->set_userdata('login', $login);
                    $user_id = $utilisateur->id; 
                    $this->session->set_userdata('user_id', $user_id);
                    $user_nom = $utilisateur->nom; 
                    $this->session->set_userdata('nom', $user_nom);
                    $user_prenom = $utilisateur->prenom;
                    $this->session->set_userdata('prenom', $user_prenom);
                    $user_email = $utilisateur->email;
                    $this->session->set_userdata('email', $user_email);

                    redirect('SAE/accueil');
                } else {
                    $this->load->view('layout/header');
                    $this->load->view('erreurs/password_false');
                    $this->load->view('layout/footer');
                }
            } else {
                $this->load->view('layout/header');
                $this->load->view('erreurs/login_false');
                $this->load->view('layout/footer');
            }
        }
    }

    public function deconnexion() {
        $this->session->sess_destroy();
        redirect('SAE/accueil');
    }
    
    public function modifier() {
        // Vérifier si l'utilisateur est connecté
        if (!$this->session->userdata('login')) {
            redirect('utilisateur/connexion');
        }
        
        $user_id = $this->session->userdata('user_id');

        // Règles de validation des champs du formulaire
        $this->form_validation->set_rules('login', 'Login', 'required');
        $this->form_validation->set_rules('nom', 'Nom', 'required');
        $this->form_validation->set_rules('prenom', 'Prénom', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Mot de passe');
    
        if ($this->form_validation->run() === FALSE) {
            // Récupérer les informations de l'utilisateur depuis la session
            $login = $this->session->userdata('login');
            $nom = $this->session->userdata('nom');
            $prenom = $this->session->userdata('prenom');
            $email = $this->session->userdata('email');

            // Affichage du formulaire de modification des informations
            $data = array(
                'login' => $login,
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email
            );
            
            $this->load->view('layout/header');
            $this->load->view('modifier_utilisateur', $data);
            $this->load->view('layout/footer');
        } else {
            // Récupération des données du formulaire
            $data = array(
                'login' => $this->input->post('login'),
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom'),
                'email' => $this->input->post('email')
            );
            
            $password = $this->input->post('password');
            if (!empty($password)) {
                $data['password'] = $password;
            }           
    
            // Appel à la fonction du modèle pour mettre à jour les informations de l'utilisateur
            $this->utilisateur_model->modifierUtilisateur($user_id, $data);

            // Changer les données contenues dans la session
            $this->session->set_userdata($data);

            redirect('SAE/accueil');
        }
    }    
}
