<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Atividade extends CI_Controller {

    /**@
    Função construtora
    @return void
    **/
    function __construct()
    {
        parent::__construct();
        $this->lang->load('auth');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else {
            $this->template->set('title', 'Atividades do aquartelamento');
            $this->template->set('nav', 'atividades');
            $this->template->set('user', $this->ion_auth->user()->row()->username);
            $this->template->set(
                'admin', ($this->ion_auth->is_admin())? true: false
            );
            $this->user_group['sois'] = $this->ion_auth->in_group('SOIS');
            $this->user_group['secpess'] = $this->ion_auth->in_group('SecPess');
            $this->user_group['admin'] = $this->ion_auth->is_admin();
        }
        $this->output->enable_profiler(TRUE);
    }

    /**@
    Listagem de atividades.
    @return void
    **/
    public function index()
    {
        unset($info);
        $info = array();
        $info = $this->input->post(null, true);
        
        $atividades = $this->atividade_model->ler($info);
        $info['atividades'] = $atividades;
        $info['permissoes'] = $this->user_group;
        //var_dump($info);
        $this->template->load('template', 'atividade/lista', $info);
    }
    
    /**@
    Nova atividade
    @return void
    **/
    public function nova()
    {
        $permissoes = $this->user_group;
        if (!$permissoes['secpess'] && !$permissoes['sois']) {
            redirect('atividade', 'refresh');
        }
        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');
        
        $info = array();

        $bipbip_bd = $this->atividade_model->ler_bipbip($info);
        $quarteis_bd = $this->militar_model->ler_quarteis($info);
        $anuario_bd = $this->atividade_model->ler_anuario($info);

        $bipbips=array();
        $quarteis=array();
        $anuarios=array();

        foreach($bipbip_bd as $bipbip){
            $bipbips[$bipbip['id']] = $bipbip['seccao'];
            }
        
        foreach($quarteis_bd as $quartel){
            $quarteis[$quartel['id']] = $quartel['quartel'];
            }
        
        foreach($anuario_bd as $anuario){
            $anuarios[$anuario['id']] = $anuario['seccao'];
            }
        
        if ($this->form_validation->run() == true) {
            
            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            
            $info['id'] = $this->atividade_model->adicionar($info);
            
            //crio os campos que vou usar para fazer o log.
            $info['user_nim'] = $this->ion_auth->user()->row()->username;
            $info['tipo'] = 'atividades';
            $info['accao'] = 'criar';
            $info['informacao'] = 'descrição: '.$info['descricao'].'; de: '.$info['de'].'; ate: '.$info['ate'].
                '; Inserido no SIRCAPE: '.$info['sircape'].'; Secção Bipbip: b|'.$info['bipbip_id'].
                '; quartel: q|'.$info['quarteis_id'].'; Secção Anuário: a|'.$info['anuario_id'];
            
            $this->registo_model->log_escreve($info);

            redirect('atividade', 'refresh');

        } else {
            $info['permissoes'] = $this->user_group;

            $info['bipbips'] = $bipbips;
            $info['quarteis'] = $quarteis;
            $info['anuarios'] = $anuarios;

            $this->template->load('template', 'atividade/novo', $info);
        }
    }

    /**@
    Edição de atividades.
    Quando adicionarem a atividade ao SIRCAPE, podem vir aki atualizar.
    Se mudar o nome, datas dos apoios, podem vir aki.
    Se cancelarem, desaparecem da lista, mas nao da db. 
    @return void
    **/
    public function edit($id = '')
    {
        $permissoes = $this->user_group;
        if (!$permissoes['secpess'] && !$permissoes['sois']) {
            redirect('atividade', 'refresh');
        }
        $info = array();

        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');

        $bipbip_bd = $this->atividade_model->ler_bipbip($info);
        $quarteis_bd = $this->militar_model->ler_quarteis($info);
        $anuario_bd = $this->atividade_model->ler_anuario($info);

        $bipbips=array();
        $quarteis=array();
        $anuarios=array();

        foreach($bipbip_bd as $bipbip){
            $bipbips[$bipbip['id']] = $bipbip['seccao'];
            }

        foreach($quarteis_bd as $quartel){
            $quarteis[$quartel['id']] = $quartel['quartel'];
            }

        foreach($anuario_bd as $anuario){
            $anuarios[$anuario['id']] = $anuario['seccao'];
            }

        $info['id'] = $id;
        $atividade = $this->atividade_model->ler($info);
        $info['atividade'] = $atividade[0];

        if ($this->form_validation->run() == true) {

            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            //o valor que vem no post, é o do indice. aqui vou buscar o nome do ficheiro

            $this->atividade_model->atualizar($info);

            //crio os campos que vou usar para fazer o log.
            $info['user_nim'] = $this->ion_auth->user()->row()->username;
            $info['tipo'] = 'atividades';
            $info['accao'] = 'atualizar';
            $info['informacao'] = 'descrição: '.$info['descricao'].'; de: '.$info['de'].'; ate: '.$info['ate'].
                '; Inserido no SIRCAPE: '.$info['sircape'].'; Secção Bipbip: b|'.$info['bipbip_id'].
                '; quartel: q|'.$info['quarteis_id'].'; Secção Anuário: a|'.$info['anuario_id'];

            $this->registo_model->log_escreve($info);

            redirect('atividade', 'refresh');

        } else {
            $info['permissoes'] = $this->user_group;

            $info['bipbips'] = $bipbips;
            $info['quarteis'] = $quarteis;
            $info['anuarios'] = $anuarios;

            $this->template->load('template', 'atividade/editar', $info);
        }
    }
}

/* End of file medalha.php */
/* Location: ./application/controllers/medalha.php */