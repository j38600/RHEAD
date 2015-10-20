<?php

class Incident_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /*
    / Tabela incident
    / ID                int(11)
    / LON               DECIMAL(9,5)
    / LAT               DECIMAL(9,5)
    / AZIMUTE           INT(11)
    / POTENCIA_RECECAO  INT(11)
    / GDH               DATETIME
    / CARACTERISTICAS   TEXT
    / ANALISADA         TINYINT(1)
    / EMISSOR_ID        INT(11)
    / FREQUENCIA        INT(11)
    / MODULACAO         ENUM('AM', 'FM', 'USB', 'LSB')
    */
    
    //funcao que le a tabela dos feriados
    function ler($info)
    {
        
        if (isset($info['id'])) {
            $this->db->where('id', $info['id']);
            $this->db->limit(1);
            $this->db->select();
        }

        $this->db->from('incident');
        $this->db->order_by('gdh', 'asc');
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao para adicionar um feriado novo
    function adicionar($info)
    {
        $this->db->insert('incident', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }
    
    //funcao para eliminar um feriado
    function apagar($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->delete('incident');
    }
}

?>