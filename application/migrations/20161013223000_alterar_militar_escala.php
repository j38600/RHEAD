<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alterar_militar_escala extends CI_Migration {

    public function up()
    {
        //campo para eu saber quem foi nomeado ou esta de prevencao.
        $this->dbforge->add_column('militares_escalas', array(
            'nomeado' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            )
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('militares_escalas', 'nomeado');
    }
}