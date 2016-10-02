<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Retirar_sircape extends CI_Migration {

    public function up()
    {
        //retirei a coluna do sircape. Estava a dar dores de cabeça nos filtros das atividades.
        $this->dbforge->drop_column('atividades', 'sircape');
    }

    public function down()
    {
        $this->dbforge->add_column('atividades', array(
            'sircape' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            )
        ));
    }
}