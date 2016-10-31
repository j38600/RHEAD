<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Trocas extends CI_Migration {

    public function up()
    {
        // Vou criar uma tabela para registar as trocas e destrocas.
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'militar_nim_um' => array(
                'type' => 'INT',
                'constraint' => 8,
                'unsigned' => TRUE
            ),
            'militar_nim_dois' => array(
                'type' => 'INT',
                'constraint' => 8,
                'unsigned' => TRUE
            ),
            'escala_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'gdh_troca' => array(
                'type' => 'DATETIME',
                'default' => NULL,
                'null' => TRUE
            ),
            'gdh_destrocas' => array(
                'type' => 'DATETIME',
                'default' => NULL,
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('militar_nim_um','militar_nim_dois','escala_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (militar_nim_um) REFERENCES militares(nim)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (militar_nim_dois) REFERENCES militares(nim)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (escala_id) REFERENCES escalas(id)');
        $this->dbforge->create_table('trocas',TRUE);

        
    }

    public function down()
    {
        $this->dbforge->drop_table('trocas');
    }
}