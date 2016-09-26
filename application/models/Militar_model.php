<?php

class Militar_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
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
        //do interface militar/lista.php diz "fora do ativo", então tenho k negar o ativo.
        if (isset($info['ativo'])) {
            $this->db->where('ativo', 0);
        }else{
            $this->db->where('ativo', 1);
        }
        if (isset($info['posto_id']) && $info['posto_id']!='') {
            $this->db->where_in('posto_id', $info['posto_id']);
        }
        if (isset($info['quartel_id']) && $info['quartel_id']!='') {
            $this->db->where_in('quartel_id', $info['quartel_id']);
        }
        if (isset($info['companhia_id']) && $info['companhia_id']!='') {
            $this->db->where_in('companhia_id', $info['companhia_id']);
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
        $this->db->order_by('nim', 'asc');
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao que le os postos que existem
    function ler_postos($info)
    {
        if (isset($info['id'])) {
            $this->db->where_in('id', $info['id']);
        }
        
        $this->db->select();
        $this->db->from('postos');
        $this->db->order_by('ordem', 'DESC');
        
        $query = $this->db->get();
        return ($query->result_array());
    }

    //funcao que le os quarteis que existem
    function ler_quarteis($info)
    {
        if (isset($info['id'])) {
            $this->db->where_in('id', $info['id']);
        }
        
        $this->db->select();
        $this->db->from('quarteis');
        
        $query = $this->db->get();
        return ($query->result_array());
    }

    //funcao que le as companhias que existem
    function ler_companhias($info)
    {
        if (isset($info['id'])) {
            $this->db->where_in('id', $info['id']);
        }
        
        $this->db->select();
        $this->db->from('companhias');
        
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

    //funcao para atualizar um militar existente
    function atualizar($info)
    {
        $this->db->where('nim', $info['nim']);
        $this->db->update('militares', $info);
        
        return true;
    }
}

?>