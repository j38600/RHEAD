<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_First extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'seccao' => array(
                'type' => 'VARCHAR',
                'constraint' => '50'
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('anuario',TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('anuario');
    }
}