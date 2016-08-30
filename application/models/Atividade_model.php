<?php

class Atividade_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /*
    / Tabela atividades
    / ID                PK INT(11)
    / DESCRICAO         VARCHAR(255)
    / DE                DATETIME
    / ATE               DATETIME
    / CANCELADA         TINYINT(0)
    / SIRCAPE           TINYINT(0)
    / BIPBIP_ID         FK INT(11)
    / ANUARIO_ID        FK INT(11)
    / QUARTEIS_ID       FK INT(11)
    */
    
    //funcao que le a tabela das atividades
    //return de listas de todas as atividades, independentemente do quartel
    //faz o join com as tabelas anuário e bipbip.
    function ler($info)
    {
        if (isset($info['cancelada'])) {
            $this->db->where('cancelada', 1);
        }else{
            $this->db->where('cancelada', 0);
        }
        if (isset($info['id'])) {
            $this->db->where('atividades.id', $info['id']);
        }
        if (isset($info['bipbip_id'])) {
            $this->db->where_in('bipbip_id', $info['bipbip_id']);
        }
        if (isset($info['anuario_id'])) {
            $this->db->where_in('anuario_id', $info['bipbip_id']);
        }
        
        $this->db->select('atividades.*');
        $this->db->select('bipbip.seccao AS seccao_bipbip');
        $this->db->select('anuario.seccao AS seccao_anuario');
        $this->db->from('atividades');
        
        //as linhas seguintes concatenam as tabelas bipbip e anuario com as atividades
        $this->db->join('bipbip', 'atividades.bipbip_id = bipbip.id');
        $this->db->join('anuario', 'atividades.anuario_id = anuario.id');
        $this->db->order_by('de', 'asc');
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao que le as secções que existem no bipbip
    function ler_bipbip($info)
    {
        if (isset($info['id'])) {
            $this->db->where_in('id', $info['id']);
        }
        
        $this->db->select();
        $this->db->from('bipbip');
        
        $query = $this->db->get();
        return ($query->result_array());
    }

    //funcao que le as secções que existem no anuario
    function ler_anuario($info)
    {
        if (isset($info['id'])) {
            $this->db->where_in('id', $info['id']);
        }
        
        $this->db->select();
        $this->db->from('anuario');
        
        $query = $this->db->get();
        return ($query->result_array());
    }

    //funcao para atualizar a informacao da tabela atividades
    function atualizar($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->update('atividades', $info);
        
        return true;
    }

    //funcao que le os quarteis que existem
    /*
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
    */
    /*
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
    */
    /*
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
    }*/
    
    //funcao para adicionar uma medalha nova nova
    function adicionar($info)
    {
        $this->db->insert('atividades', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }
    
    /*
    //funcao para atribuir uma medalha a um militar
    function atribuir($info)
    {
        $this->db->insert('militares_med_cond', $info);
        return true;
    }
    */
    /*
    //funcao para atualizar as datas de uma medalha a um militar
    function atualizar_militar_med_cond($info)
    {
        $this->db->where('militar_nim', $info['militar_nim']);
        $this->db->where('med_cond_id', $info['med_cond_id']);
        $this->db->update('militares_med_cond', $info);
        return true;
    }
    */
    /*
    function atualizar_stock($info)
    {
        $this->db->set('stock', $info['stock']);
        $this->db->where('id', $info['med_cond_id']);
        $this->db->update('medalhas_condecoracoes');
        return true;
    }
    */
}

?>