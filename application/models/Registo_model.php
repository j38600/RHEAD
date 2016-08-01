<?php

class Registo_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    /*
    / Tabela log
    / ID  | MILITAR_NIM | GDH     | IP_MAQUINA | ACCAO  | TIPO    | INFORMACAO
    / int | int         | datetime| varchar    | varchar| varchar | varchar
    /
    /na coluna tipo, digo o ambito do registo, se é militar, ou medalha, ou atividades(sois), etc
    /na coluna accao descrimino um pouco mais, se é novo, ou criar, ou alterar, etc.
    /na informação faço a descrição promenorizada do que se trata.

    */
    
    function log_escreve ($info)
    {
        //$info tem que trazer 2 variaveis dentro dela: accao e tipo.
        $this->db->set('militar_nim', $info['user_nim']);
        $mysqltime = date("Y-m-d H:i:s");
        $this->db->set('gdh', $mysqltime);
        $this->db->set('ip_maquina', gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $this->db->set('accao', $info['accao']);
        $this->db->set('tipo', $info['tipo']);
        $this->db->set('informacao', $info['informacao']);
        $this->db->insert('registos');
        
        return true;
    }

    function ler($info)
    {
        if (isset($info['obter'])) {
            $this->db->where('tipo', $info['obter']);
        }
        //switch ($info['obter']){
        //case('militares'):
        //    $this->db->where('tipo', 1);
        //    break;
        //case('medalhas'):
        //    $this->db->where('tipo', 2);
        //    break;
        //case('atividades'):
        //    $this->db->where('tipo', 3);
        //    break;
        //}
        $this->db->select('registos.*, users.username');
        $this->db->from('registos');
        $this->db->join('users', 'registos.militar_nim = users.username');
        $this->db->order_by('gdh', 'desc');
        $query = $this->db->get();

        return ($query->result_array());
    }
}

?>