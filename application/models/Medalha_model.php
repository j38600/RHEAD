<?php

class Medalha_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    //funcao que le a tabela das medalhas e condecorações
    //return de listas de militares, com um join da tabela de medalhas.
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
        $this->db->select('medalhas_condecoracoes.nome AS med_cond_nome, medalhas_condecoracoes.descricao AS med_cond_descricao, medalhas_condecoracoes.stock AS stock');
        
        $this->db->from('militares_med_cond');
        
        //as linhas seguintes concatenam as medalhas e condecorações aos militares
        $this->db->join('medalhas_condecoracoes', 'medalhas_condecoracoes.id = militares_med_cond.med_cond_id');
        //$this->db->order_by('apelido', 'asc');
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao que le a tabela das medalhas e condecorações
    //return de listas de militares, com um join da tabela de militares
    function ler_militar_medalha($info)
    {
        if (isset($info['id'])) {
            $this->db->where('militar_nim', $info['id']);
        }
        if (isset($info['por_receber'])) {
            $this->db->where_in('recebida', 0);
        }
        if (isset($info['por_impor'])) {
            $this->db->where_in('imposta', 0);
        }
        if (isset($info['para_proposta'])) {
            $this->db->where_in('proposta', 0);
        }
        if (isset($info['proxima_cerimonia'])) {
            $this->db->where_in('impor_proxima_cerimonia', 1);
        }
        $this->db->select('militares_med_cond.*');
        //as linhas seguintes alteram os nomes aos campos do posto, companhia, quartel dos militares
        $this->db->select('militares.nome AS militar_nome, militares.apelido AS militar_apelido, postos.abreviatura AS posto_abreviatura');
        
        $this->db->from('militares_med_cond');
        
        //as linhas seguintes concatenam as medalhas e condecorações aos militares
        $this->db->join('militares', 'militares.nim = militares_med_cond.militar_nim');
        $this->db->join('postos', 'postos.id = militares.posto_id');
        //$this->db->order_by('apelido', 'asc');
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao que le os nims que ja teem uma medalha.
    //igual a ler_militar, mas sem o join à tabela das medalhas.
    function ler_nims($info)
    {
        if (isset($info['id'])) {
            $this->db->where_in('med_cond_id', $info['id']);
        }
        $this->db->select('militares_med_cond.*');
        $this->db->from('militares_med_cond');
        
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao que le a tabela das medalhas e condecoracoes
    function ler($info)
    {
        
        if (isset($info['id'])) {
            $this->db->where('id', $info['id']);
            $this->db->limit(1);
        }
        $this->db->select('medalhas_condecoracoes.*, COUNT(militares_med_cond.med_cond_id) as nr_militares');
        $this->db->from('medalhas_condecoracoes');
        $this->db->join('militares_med_cond', 'militares_med_cond.med_cond_id = medalhas_condecoracoes.id', 'left');
        $this->db->group_by('medalhas_condecoracoes.id');
        
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao para adicionar uma medalha nova nova
    function adicionar($info)
    {
        $this->db->insert('medalhas_condecoracoes', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }
    
    //funcao para atribuir uma medalha a um militar
    function atribuir($info)
    {
        $this->db->insert('militares_med_cond', $info);
        return true;
    }

    //funcao para atualizar as datas de uma medalha a um militar
    function atualizar_militar_med_cond($info)
    {
        $this->db->where('militar_nim', $info['militar_nim']);
        $this->db->where('med_cond_id', $info['med_cond_id']);
        $this->db->update('militares_med_cond', $info);
        return true;
    }

    function atualizar_stock($info)
    {
        $this->db->set('stock', $info['stock']);
        $this->db->where('id', $info['med_cond_id']);
        $this->db->update('medalhas_condecoracoes');
        return true;
    }
}

?>