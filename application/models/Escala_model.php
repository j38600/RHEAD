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

    //funcao para atualizar a informacao da tabela escalas
    function atualizar($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->update('escalas', $info);
        
        return true;
    }

    //funcao para atualizar a informacao da tabela escalas
    function atualizar_dispensa($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->update('indisponibilidades', $info);
        
        return true;
    }

    //funcao que le a tabela das indisponibilidades
    function ler_nims_dispensa($info)
    {
        if (isset($info['id'])) {
            $this->db->where_in('indisponibilidade_id', $info['id']);
        }
        
        $this->db->select('militares_indisponibilidades.*');
        $this->db->from('militares_indisponibilidades');
        
        $query = $this->db->get();
        
        return ($query->result_array());
    }

    //funcao que le a tabela das dispenas
    function ler_dispensa($info)
    {
        
        if (isset($info['id'])) {
            $this->db->where('indisponibilidades.id', $info['id']);
            $this->db->limit(1);
        }
        $this->db->select('indisponibilidades.*');
        $this->db->select('razoes.razao, razoes.descricao AS descricao_razao');
        $this->db->select('COUNT(militares_indisponibilidades.indisponibilidade_id) as nr_militares');
        $this->db->from('indisponibilidades');
        $this->db->join('militares_indisponibilidades',
            'militares_indisponibilidades.indisponibilidade_id = indisponibilidades.id', 'left');
        $this->db->join('razoes', 'indisponibilidades.razao_id = razoes.id');
        $this->db->group_by('indisponibilidades.id');
        
        $query = $this->db->get();
        
        return ($query->result_array());
    }

    //funcao para associar um militar a uma indisponibilidade
    function associar_dispensa($info)
    {
        $this->db->insert('militares_indisponibilidades', $info);
        return true;
    }

    //funcao para adicionar uma escala nova
    function adicionar_dispensa($info)
    {
        $this->db->insert('indisponibilidades', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }

    //funcao que le as razões
    function ler_razoes($info)
    {
        if (isset($info['id'])) {
            $this->db->where_in('id', $info['id']);
        }
        
        $this->db->select('*');
        $this->db->from('razoes');
        
        $query = $this->db->get();
        
        return ($query->result_array());
    }

    //funcao para atualizar a informacao da tabela razoes
    function atualizar_razao($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->update('razoes', $info);
        
        return true;
    }

    //funcao para adicionar uma razao nova
    function adicionar_razao($info)
    {
        $this->db->insert('razoes', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }

    //funcao que le a tabela dos feriados
    function ler_feriado($info)
    {
        
        if (isset($info['id'])) {
            $this->db->where('id', $info['id']);
            $this->db->limit(1);
        }
        $this->db->select('*');
        $this->db->from('feriados');
        $this->db->order_by('data', 'asc');
        
        $query = $this->db->get();
        
        return ($query->result_array());
    }

    //funcao para atualizar a informacao da tabela feriados
    function atualizar_feriado($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->update('feriados', $info);
        
        return true;
    }

    //funcao para adicionar um feriado novo
    function adicionar_feriado($info)
    {
        $this->db->insert('feriados', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }    
}

?>