<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Escalas_militares extends CI_Migration {

    public function up()
    {
        //Adicionar tabelas com informacao das escalas,razoes para estar dispensado, 
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'razao' => array(
                'type' => 'VARCHAR',
                'constraint' => '250'
            ),
            'descricao' => array(
                'type' => 'VARCHAR',
                'constraint' => '250'
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('razoes',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'escala' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'diario' => array(
                'type' => 'TINYINT',
                'constraint' => 1
            ),
            'hora_inicio' => array(
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00'
            ),
            'hora_fim' => array(
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00'
            ),
            //a duração será medida em dias??
            'duracao' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1
            ),
            //mais tarde acho que vou ter que descriminar o numero de militares a nomear por classe ou posto.
            'n_nomeados' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('escalas',TRUE);
        
        // Vou criar uma tabela para dizer que militares fazem que escala.
        $this->dbforge->add_field(array(
            'militar_nim' => array(
                'type' => 'INT',
                'constraint' => 8,
                'unsigned' => TRUE
            ),
            'escala_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'gdh_ultimo' => array(
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00'
            )
        ));
        $this->dbforge->add_key('militar_nim','escala_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (militar_nim) REFERENCES militares(nim)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (escala_id) REFERENCES escalas(id)');
        $this->dbforge->create_table('militares_escalas',TRUE);

        //criar as tabelas intermédias, para relacionar as razoes com as escalas,
        $this->dbforge->add_field(array(
            'razao_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'escala_id' => array(
                'type' => 'INT',
                'constraint' => 11
            )
        ));
        $this->dbforge->add_key('razao_id','escala_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (razao_id) REFERENCES razoes(id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (escala_id) REFERENCES escalas(id)');
        $this->dbforge->create_table('razoes_escalas',TRUE);

        //vou centrar-me nas indisponibilidades. Elas teem uma razao, data de inicio e fim.
        //e associo os militares nao as razoes, mas as indisponibilidades.
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'razao_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'gdh_inicio' => array(
                'type' => 'DATETIME'
            ),
            'gdh_fim' => array(
                'type' => 'DATETIME'
            ),
            'informacao' => array(
                'type' => 'VARCHAR',
                'constraint' => '250'
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->add_key('razao_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (razao_id) REFERENCES razoes(id)');
        $this->dbforge->create_table('indisponibilidades',TRUE);

        $this->dbforge->add_field(array(
            'militar_nim' => array(
                'type' => 'INT',
                'constraint' => 8,
                'unsigned' => TRUE
            ),
            'indisponibilidade_id' => array(
                'type' => 'INT',
                'constraint' => 11
            )
        ));
        $this->dbforge->add_key('militar_nim','indisponibilidade_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (militar_nim) REFERENCES militares(nim)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (indisponibilidade_id) REFERENCES indisponibilidades(id)');
        $this->dbforge->create_table('militares_indisponibilidades',TRUE);

        
    }

    public function down()
    {
        $this->dbforge->drop_table('razoes');
        $this->dbforge->drop_table('escalas');
        $this->dbforge->drop_table('militares_escalas');
        $this->dbforge->drop_table('razoes_escalas');
        $this->dbforge->drop_table('indisponibilidades');
        $this->dbforge->drop_table('militares_indisponibilidades');
    }
}