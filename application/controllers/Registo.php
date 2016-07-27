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
    Posso usar tabs em cima, por defeito começo logo no historico dos militares
    Posso usar uma variavel que passo para o index, para dizer se quero
        o historico dos mliares, ou das medalhas, ou do registo das atividades da sois.
    Implementar paginação?
    @return void
    **/
    public function index($obter = '')
    {
        redirect('registo/militares', 'refresh');
    }

    /**@
    Listagem do registo de atividades com militares
    adição, edição de posto, alteração de companhia, etc.
    @return void
    **/
    public function militares()
    {
        //ainda não funca
        $info = array();
        $info['obter'] = 'militares';
        $info['registos'] = $this->registo_model->ler($info);
        $info['permissoes'] = $this->user_group;
        $this->template->load('template', 'registo/militares', $info);
    }

    /**@
    Listagem do registo de atividades com medalhas
    adição, edição de informações, nomeações, medalhas recebidas, impostas, etc.
    @return void
    **/
    public function medalhas()
    {
        //ainda nao funca
        $info = array();
        $info['obter'] = 'medalhas';
        $info['registos'] = $this->registo_model->ler($info);
        $this->template->load('template', 'registo/medalhas', $info);
    }

    /**@
    Listagem do registo de atividades com atividades(SOIS)
    adição de atividades, remoção, confirmação, edição, etc.
    @return void
    **/
    public function atividades()
    {
        //ainda nao funca
        $info = array();
        $info['obter'] = 'atividades';
        $info['registos'] = $this->registo_model->ler($info);
        $this->template->load('template', 'registo/atividades', $info);
    }
}