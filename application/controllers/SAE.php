<?php
class SAE extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }
    
    public function accueil() {
        if ($this->session->userdata('login')) {
            // Utilisateur connecté
            $data['nom'] = $this->session->userdata('nom');
            $data['prenom'] = $this->session->userdata('prenom');
            $this->load->view('layout/header');
            $this->load->view('accueil_connecte', $data);
            $this->load->view('layout/footer_accueil');
        } else {
            // Utilisateur non connecté
            $this->load->view('layout/header');
            $this->load->view('accueil_non_connecte');
            $this->load->view('layout/footer_accueil');

        }
    }
}