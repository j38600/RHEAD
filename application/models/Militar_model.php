<?php

class Militar_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /*
    / Tabela militar
    / NIM               INT(8)
    / NOME              VARCHAR(200)
    / APELIDO           VARCHAR(50)
    / ANTIGUIDADE       DATETIME
    / NOTA_CURSO        INT(4)
    / ATIVO             INT(11)
    / POSTO_ID          FK INT(11)
    / QUARTEL_ID        FK INT(11)
    / COMPANHIA_ID      FK INT(11)
    */
    
    //funcao que le a tabela dos militares
    function ler($info)
    {
        if (isset($info['id'])) {
            $this->db->where('nim', $info['id']);
            $this->db->limit(1);
        }
        if (isset($info['nims'])) {
            $this->db->where_in('nim', $info['nims']);
        }
        
        $this->db->select('militares.*');
        //as linhas seguintes alteram os nomes aos campos do posto, companhia, quartel dos militares
        $this->db->select('postos.abreviatura AS posto_abreviatura, postos.posto AS posto_nome');
        $this->db->select('companhias.abreviatura AS companhia_abreviatura, companhias.companhia AS companhia_nome');
        $this->db->select('quarteis.abreviatura AS quartel_abreviatura, quarteis.quartel AS quartel_nome');
        
        $this->db->from('militares');
        
        //as linhas seguintes concatenam o posto, companhia, quartel aos militares
        $this->db->join('postos', 'postos.id = militares.posto_id');
        $this->db->join('companhias', 'companhias.id = militares.companhia_id');
        $this->db->join('quarteis', 'quarteis.id = militares.quartel_id');
        //$this->db->order_by('apelido', 'asc');
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao para adicionar um militar novo
    function adicionar($info)
    {
        $this->db->insert('militares', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }
}

?>