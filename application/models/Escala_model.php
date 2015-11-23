<?php

class Escala_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /*
    / Tabela escala
    / ID                INT(11)
    / NOME              VARCHAR(200)
    / DIARIO            TINYINT(1)
    / NUMERO_NOMEADOS   INT(11)
    / HORA_INICIO       DATETIME
    / HORA_FIM          DATETIME
    / SEMANA            TINYINT(1)
    / HORAS_DURACAO     INT(11)
    */
    
    //funcao que le a tabela das escalas
    function ler($info)
    {
        
        if (isset($info['id'])) {
            $this->db->where('id', $info['id']);
            $this->db->limit(1);
        }
        
        $this->db->select('escalas.*, COUNT(militares_escalas.escalas_id) as nr_militares');
        $this->db->from('escalas');
        $this->db->join('militares_escalas', 'militares_escalas.escalas_id = escalas.id', 'left');
        $this->db->group_by('escalas.id');
        
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao para adicionar uma escala nova
    function adicionar($info)
    {
        $this->db->insert('escalas', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }
}

?>