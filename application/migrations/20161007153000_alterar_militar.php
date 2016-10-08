<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alterar_militar extends CI_Migration {

    public function up()
    {
        //mudei o nome de antiguidade para data_promocao e adicionei um campo antiguidade(INT)
        $this->dbforge->modify_column('militares', array(
            'antiguidade' => array(
                'name' => 'data_promocao',
                'type' => 'DATETIME'
            )
        ));
        $this->dbforge->add_column('militares', array(
            'antiguidade' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            )
        ));
        //adicionar tabela das razoes

        //adicionar tabela das escalas

        //adicionar 
    }

    public function down()
    {
        $this->dbforge->drop_column('militares', 'antiguidade');
        $this->dbforge->modify_column('militares', array(
            'data_promocao' => array(
                'name' => 'antiguidade',
            )
        ));
    }
}