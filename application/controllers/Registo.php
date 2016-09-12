<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registo extends CI_Controller {
    
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
            $this->template->set('title', 'Histórico de atividades');
            $this->template->set('nav', 'registo');
            $this->template->set('user', $this->ion_auth->user()->row()->username);
            $this->template->set(
                'admin', ($this->ion_auth->is_admin())? true: false
            );
            $this->user_group['sois'] = $this->ion_auth->in_group('SOIS');
            $this->user_group['secpess'] = $this->ion_auth->in_group('SecPess');
            $this->user_group['admin'] = $this->ion_auth->is_admin();
        }
        //$this->output->enable_profiler(TRUE);
    }
    
    /**@
    Listagem da atividade do site.
    Uso tabs em cima, por defeito começo logo no historico dos militares
    Implementar paginação?
    @return void
    **/
    public function lista($obter = '')
    {
        $info = array();
        $info['obter'] = $obter;
        $info['registos'] = $this->registo_model->ler($info);
        $info['permissoes'] = $this->user_group;
        $this->template->load('template', 'registo/lista', $info);
    }

}