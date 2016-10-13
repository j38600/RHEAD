<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alterar_feriado extends CI_Migration {

    public function up()
    {
        //preciso de guardar o nome do feriado / razao de passar a escala B
        $this->dbforge->add_column('feriados', array(
            'nome' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            )
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('feriados', 'nome');
    }
}