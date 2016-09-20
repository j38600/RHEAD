<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Second extends CI_Migration {

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
        $this->dbforge->create_table('bipbip',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'companhia' => array(
                'type' => 'VARCHAR',
                'constraint' => '200'
            ),
            'abreviatura' => array(
                'type' => 'VARCHAR',
                'constraint' => '50'
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('companhias',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'quartel' => array(
                'type' => 'VARCHAR',
                'constraint' => '200'
            ),
            'abreviatura' => array(
                'type' => 'VARCHAR',
                'constraint' => '50'
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('quarteis',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'posto' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'abreviatura' => array(
                'type' => 'VARCHAR',
                'constraint' => '50'
            ),
            'ordem' => array(
                'type' => 'INT',
                'constraint' => 11
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('postos',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'descricao' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'de' => array(
                'type' => 'DATETIME'
            ),
            'ate' => array(
                'type' => 'DATETIME'
            ),
            'cancelada' => array(
                'type' => 'TINYINT',
                'constraint' => 4,
                'default' => 0
            ),
            'sircape' => array(
                'type' => 'TINYINT',
                'constraint' => 4,
                'default' => 0
            ),
            'bipbip_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'anuario_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'quarteis_id' => array(
                'type' => 'INT',
                'constraint' => 11
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->add_key('bipbip_id');
        $this->dbforge->add_key('anuario_id');
        $this->dbforge->add_key('quarteis_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (bipbip_id) REFERENCES bipbip(id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (anuario_id) REFERENCES anuario(id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (quarteis_id) REFERENCES quarteis(id)');
        $this->dbforge->create_table('atividades',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'data' => array(
                'type' => 'DATETIME'
            ),
            'quartel_id' => array(
                'type' => 'INT',
                'constraint' => 11
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->add_key('quartel_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (quartel_id) REFERENCES quarteis(id)');
        $this->dbforge->create_table('feriados',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '15'
            ),
            'login' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'time' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'default' => NULL
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('login_attempts',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '20'
            ),
            'description' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('groups',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' =>TRUE,
                'auto_increment' => TRUE
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '15'
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'salt' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
                'default' => NULL
            ),
            'activation_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => TRUE,
                'default' => NULL
            ),
            'forgotten_password_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => TRUE,
                'default' => NULL
            ),
            'forgotten_password_time' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE,
                'default' => NULL
            ),
            'remember_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => TRUE,
                'default' => NULL
            ),
            'created_on' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'last_login' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE,
                'default' => NULL
            ),
            'active' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'null' => TRUE,
                'default' => NULL
            ),
            'first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
                'default' => NULL
            ),
            'last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
                'default' => NULL
            ),
            'company' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'default' => NULL
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE,
                'default' => NULL
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('users',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'group_id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => TRUE
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key('group_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (group_id) REFERENCES groups(id)');
        $this->dbforge->create_table('users_groups',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'nome' => array(
                'type' => 'VARCHAR',
                'constraint' => '200'
            ),
            'diario' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
            ),
            'numero_nomeados' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'hora_inicio' => array(
                'type' => 'DATETIME'
            ),
            'hora_fim' => array(
                'type' => 'DATETIME'
            ),
            'semana' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
            ),
            'horas_duracao' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 24
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('escalas',TRUE);

        $this->dbforge->add_field(array(
            'nim' => array(
                'type' => 'INT',
                'constraint' => 8,
                'unsigned' => TRUE
            ),
            'nome' => array(
                'type' => 'VARCHAR',
                'constraint' => '200'
            ),
            'apelido' => array(
                'type' => 'VARCHAR',
                'constraint' => '50'
            ),
            'antiguidade' => array(
                'type' => 'DATETIME'
            ),
            'nota_curso' => array(
                'type' => 'INT',
                'constraint' => 4
            ),
            'ativo' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
            ),
            'posto_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'quartel_id' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'companhia_id' => array(
                'type' => 'INT',
                'constraint' => 11
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->add_key('quartel_id');
        $this->dbforge->add_key('posto_id');
        $this->dbforge->add_key('companhia_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (posto_id) REFERENCES postos(id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (quartel_id) REFERENCES quarteis(id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (companhia_id) REFERENCES companhias(id)');
        $this->dbforge->create_table('militares',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'militar_nim' => array(
                'type' => 'INT',
                'constraint' => 8,
                'unsigned' => TRUE
            ),
            'gdh_inicio' => array(
                'type' => 'DATETIME'
            ),
            'gdh_fim' => array(
                'type' => 'DATETIME'
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->add_key('militar_nim');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (militar_nim) REFERENCES militares(nim)');
        $this->dbforge->create_table('indisponibilidades',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'nome' => array(
                'type' => 'VARCHAR',
                'constraint' => '250'
            ),
            'descricao' => array(
                'type' => 'TEXT'
            ),
            'stock' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->create_table('medalhas_condecoracoes',TRUE);

        $this->dbforge->add_field(array(
            'militar_nim' => array(
                'type' => 'INT',
                'constraint' => 8,
                'unsigned' => TRUE
            ),
            'escalas_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'gdh_ultimo' => array(
                'type' => 'DATETIME',
                'default' => NULL
            )
        ));
        $this->dbforge->add_key('militar_nim','escalas_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (militar_nim) REFERENCES militares(nim)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (escalas_id) REFERENCES escalas(id)');
        $this->dbforge->create_table('militares_escalas',TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'militar_nim' => array(
                'type' => 'INT',
                'constraint' => 8,
                'unsigned' => TRUE
            ),
            'gdh' => array(
                'type' => 'DATETIME'
            ),
            'ip_maquina' => array(
                'type' => 'VARCHAR',
                'constraint' => '50'
            ),
            'tipo' => array(
                'type' => 'VARCHAR',
                'constraint' => '45'
            ),
            'accao' => array(
                'type' => 'VARCHAR',
                'constraint' => '50'
            ),
            'informacao' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            )
        ));
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->add_key('militar_nim');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (militar_nim) REFERENCES militares(nim)');
        $this->dbforge->create_table('registos',TRUE);

        $this->dbforge->add_field(array(
            'militar_nim' => array(
                'type' => 'INT',
                'constraint' => 8,
                'unsigned' => TRUE
            ),
            'med_cond_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'proposta' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ),
            'data_proposta' => array(
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00'
            ),
            'pedida' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ),
            'data_pedida' => array(
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00'
            ),
            'recebida' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ),
            'data_recebida' => array(
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00'
            ),
            'imposta' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ),
            'data_imposta' => array(
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00'
            ),
            'informacao' => array(
                'type' => 'TEXT'
            ),
            'impor_proxima_cerimonia' => array(
                'type' => 'TINYINT',
                'constraint' => 4,
                'default' => 0
            )
        ));
        $this->dbforge->add_key('militar_nim','med_cond_id');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (militar_nim) REFERENCES militares(nim)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (med_cond_id) REFERENCES medalhas_condecoracoes(id)');
        $this->dbforge->create_table('militares_med_cond',TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('militares_med_cond');
        $this->dbforge->drop_table('registos');
        $this->dbforge->drop_table('militares_escalas');
        $this->dbforge->drop_table('medalhas_condecoracoes');
        $this->dbforge->drop_table('indisponibilidades');
        $this->dbforge->drop_table('militares');
        $this->dbforge->drop_table('escalas');
        $this->dbforge->drop_table('users_groups');
        $this->dbforge->drop_table('users');
        $this->dbforge->drop_table('groups');
        $this->dbforge->drop_table('login_attempts');
        $this->dbforge->drop_table('feriados');
        $this->dbforge->drop_table('atividades');
        $this->dbforge->drop_table('bipbip');
        $this->dbforge->drop_table('companhhias');
        $this->dbforge->drop_table('quarteis');
        $this->dbforge->drop_table('postos');
    }
}