<?php

class Emitter_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /*
    / Tabela emitter
    / ID                int(11)
    / LON               DECIMAL(9,5)
    / LAT               DECIMAL(9,5)
    / POTENCIA_EMISSAO  INT(11)
    / TIPOLOGIA         ENUM('FIXO', 'VEICUALR', 'MANPACK', 'DESCONHECIDO')
    / DESCRICAO         TEXT
    / CARACTERISTICAS   TEXT
    / FREQ_MAX          INT(11)
    / FREQ_MIN          INT(11)
    / NOME              VARCHAR(200)
    / ATIVO             TINYINT(1)
    */
    
    //funcao que le a tabela dos feriados
    function ler($info)
    {
        
        if (isset($info['id'])) {
            $this->db->where('id', $info['id']);
            $this->db->limit(1);
            $this->db->select();
        }

        $this->db->from('emitter');
        $this->db->order_by('nome', 'asc');
        $query = $this->db->get();
        
        return ($query->result_array());
    }
    
    //funcao para adicionar um feriado novo
    function adicionar($info)
    {
        $this->db->insert('emitter', $info);
        $novo_id = $this->db->insert_id();
        return $novo_id;
    }
    
    //funcao para eliminar um feriado
    function apagar($info)
    {
        $this->db->where('id', $info['id']);
        $this->db->delete('emitter');
    }
}

?>