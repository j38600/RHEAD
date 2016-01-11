<?php

class Medalha_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /*
    / Tabela medalha
    / MILITAR_NIM       FK INT(8)
    / MED_COND_ID       FK INT(11)
    / PEDIDA            TINYINT
    / DATA_PEDIDA       DATETIME NULL
    / RECEBIDA          TINYINT
    / DATA_RECEBIDA     DATETIME NULL
    / IMPOSTA           TINYINT
    / DATA_IMPOSTA      DATETIME NULL
    */
    
    //funcao que le a tabela das medalhas e condecorações
    function ler_militar($info)
    {
        if (isset($info['id'])) {
            $this->db->where('militar_nim', $info['id']);
        }
        if (isset($info['med_cond'])) {
            $this->db->where_in('med_cond_id', $info['med_cond']);
        }
        
        $this->db->select('militares_med_cond.*');
        //as linhas seguintes alteram os nomes aos campos do posto, companhia, quartel dos militares
        $this->db->select('medalhas_condecoracoes.nome AS med_cond_nome, medalhas_condecoracoes.descricao AS med_cond_descricao');
        
        $this->db->from('militares_med_cond');
        
        //as linhas seguintes concatenam o posto, companhia, quartel aos militares
        $this->db->join('medalhas_condecoracoes', 'medalhas_condecoracoes.id = militares_med_cond.med_cond_id');
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