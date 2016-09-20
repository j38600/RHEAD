<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Atividades_militares extends CI_Migration {

    public function up()
    {
        //adicionei campos a tabela atividades para registar noticias, fotografias e rel_emp_op.
        //adicionei uma tabela para ter como saber que militares e k estiveram em que atividades.
        $this->dbforge->add_column('atividades', array(
            'fotografias' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ),
            'noticia' => array(
                'type' => 'TEXT'
            ),
            'rel_empenhamento_op' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            )
        ));

        $this->dbforge->add_field(array(
            'militar_nim' => array(
                'type' => 'INT',
                'constraint' => 8,
                'unsigned' => TRUE
            ),
            'atividade_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'gdh_inicio' => array(
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00'
            ),
            'gdh_fim' => array(
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00'
            ),
            'informacao' => array(
                'type' => 'TEXT'
            )
        ));
        $this->dbforge->add_key('militar_nim','atividade_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (militar_nim) REFERENCES militares(nim)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (atividade_id) REFERENCES atividades(id)');
        $this->dbforge->create_table('militares_atividades',TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_column('atividades', 'fotografias');
        $this->dbforge->drop_column('atividades', 'noticia');
        $this->dbforge->drop_column('atividades', 'rel_empenhamento_op');
        $this->dbforge->drop_table('militares_atividades');
    }
}