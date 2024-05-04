<?php
class Utilisateur_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function creerUtilisateur($data) {
        $this->db->insert('utilisateurs', $data);
        return $this->db->insert_id();
    }

    public function recupHash($login) {
        $this->db->select('password');
        $this->db->from('utilisateurs');
        $this->db->where('login', $login);
        $query = $this->db->get();
    
        if ($query->num_rows() === 1) {
            return $query->row()->password;
        } else {
            return false;
        }
    }

    public function recupDonnees($login) {
        $this->db->where('login', $login);
        $query = $this->db->get('utilisateurs');
        return $query->row();
    }  

    public function modifierUtilisateur($user_id, $data) {
        // Modifier les informations de l'utilisateur dans la base de données
        $this->db->where('id', $user_id);
        $this->db->update('utilisateurs', array(
            'login' => $data['login'],
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email']
        ));
    
        // Si le mot de passe a été modifié
        if (isset($data['password']) && !empty($data['password'])) {
            // Hash
            $hash = password_hash($data['password'], PASSWORD_DEFAULT);
    
            // Modifier le mot de passe dans la base de données
            $this->db->set('password', $hash);
            $this->db->where('id', $user_id);
            $this->db->update('utilisateurs');
        }
    }
    
    
}