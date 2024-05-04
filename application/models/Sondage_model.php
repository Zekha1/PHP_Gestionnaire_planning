<?php
class Sondage_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function creerSondage($data, $dates) {
        $this->db->trans_start();

        $this->db->insert('sondages', $data);
        $sondage_cle = $data['cle'];

        foreach ($dates as $date) {
            $this->db->insert('dates_sondages', array('sondage_cle' => $sondage_cle, 'date' => $date));
        }

        $this->db->trans_complete();

        return $sondage_cle;
    }

    public function enregistrerReponse($nom, $sondage_cle, $date_id) {
        $data = array(
            'nom' => $nom,
            'sondage_cle' => $sondage_cle,
            'sondage_date' => $date_id,
        );
    
        $this->db->insert('reponses_sondages', $data);
    }    
    
    public function getReponsesSondage($sondage_cle) {
        $this->db->select('dates_sondages.date, reponses_sondages.nom');
        $this->db->from('dates_sondages');
        $this->db->join('reponses_sondages', 'dates_sondages.id = reponses_sondages.sondage_date');
        $this->db->where('dates_sondages.sondage_cle', $sondage_cle);
        $this->db->order_by('dates_sondages.date', 'asc');
        $query = $this->db->get();
    
        return $query->result();
    }
    
    public function cloturerSondage($sondage_cle) {
        $data = array(
            'enCours' => FALSE
        );
    
        $this->db->where('cle', $sondage_cle);
        $this->db->update('sondages', $data);
    }

    public function getDatesSondage($sondage_cle) {
        $this->db->select('dates_sondages.*');
        $this->db->from('sondages');
        $this->db->join('dates_sondages', 'sondages.cle = dates_sondages.sondage_cle');
        $this->db->where('sondages.cle', $sondage_cle);
    
        $query = $this->db->get();
        return $query->result();
    }

    public function getIdDate($sondage_cle) {
        $this->db->select('dates_sondages.id');
        $this->db->from('sondages');
        $this->db->join('dates_sondages', 'sondages.cle = dates_sondages.sondage_cle');
        $this->db->where('sondages.cle', $sondage_cle);
    
        $query = $this->db->get();
        $result = $query->row();
    
        if ($result) {
            return $result->id;
        } else {
            return null;
        }
    }

    public function getSondagesCreesParUtilisateur($user_id) {
        $this->db->select('*');
        $this->db->from('sondages');
        $this->db->where('auteur_id', $user_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    public function getSondageByKey($sondage_cle){
        $query = $this->db->get_where('sondages', array('cle' => $sondage_cle));
        return $query->row();
    }   

    public function supprimerSondage($sondage_cle) {
        // Supprimer les réponses associées au sondage
        $this->db->where('sondage_cle', $sondage_cle);
        $this->db->delete('reponses_sondages');
    
        // Supprimer les dates associées au sondage
        $this->db->where('sondage_cle', $sondage_cle);
        $this->db->delete('dates_sondages');
    
        // Supprimer le sondage lui-même
        $this->db->where('cle', $sondage_cle);
        $this->db->delete('sondages');
    }
    
    public function getReponsesUtilisateur($sondage_cle, $nom) {
        $this->db->select('*');
        $this->db->from('reponses_sondages');
        $this->db->where('sondage_cle', $sondage_cle);
        $this->db->where('nom', $nom);
        $query = $this->db->get();
        return $query->result();
    }    
    
    public function supprimerReponses($sondage_cle, $nom) {
        // Supprimer les anciennes réponses de l'utilisateur
        $this->db->where('sondage_cle', $sondage_cle);
        $this->db->where('nom', $nom);
        $this->db->delete('reponses_sondages');
    }      
}
