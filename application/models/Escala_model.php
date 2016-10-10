<?php

class Escala_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    
    //funcao que le a tabela das escalas
    function ler($info)
    {
        
        if (isset($info['id'])) {
            $this->db->where('id', $info['id']);
            $this->db->limit(1);
        }
        $this->db->select('escalas.*');
        $this->db->select('COUNT(militares_escalas.escala_id) as nr_militares');
        $this->db->from('escalas');
        $this->db->join('militares_escalas', 'militares_escalas.escala_id = escalas.id', 'left');
        $this->db->group_by('escalas.id');
        
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao que le a tabela das escalas
    function ler_nims($info)
    {
        if (isset($info['id'])) {
            $this->db->where_in('escala_id', $info['id']);
        }
        
        $this->db->select('militares_escalas.*');
        $this->db->from('militares_escalas');
        
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

    //funcao para associar uma atividade a um militar
    function associar($info)
    {
        $this->db->insert('militares_escalas', $info);
        return true;
    }
}

?>