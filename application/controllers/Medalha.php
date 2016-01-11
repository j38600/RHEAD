<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medalha extends CI_Controller {

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
            $this->template->set('title', 'Medalhas e Condecorações');
            $this->template->set('nav', 'medalhas');
            $this->template->set('user', $this->ion_auth->user()->row()->username);
            $this->template->set(
                'admin', ($this->ion_auth->is_admin())? true: false
            );
        }
        $this->output->enable_profiler(TRUE);
    }

    /**@
    Listagem de medalhas e condecorações existentes
    + botoes para atribuir a um militar
    + botao no fim para adicionar medalha ou condecoração nova.
    <nome da medalha | # de militares | Atribuir>
    @return void
    **/
    public function index()
    {
        $info = array();
        $medalhas = $this->medalha_model->ler($info);
        
        var_dump($medalhas);
        //break;
        //$info['nr_militares_escalas'] = 1;
        //$nr_militares_p_escala = $this->escala_model->ler($info);
        
        
        $info['medalhas'] = $medalhas;
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'medalha/list', $info);
    }
    
    /**@
    Nova medalha ou condecoração
    @return void
    **/
    public function novo()
    {
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');
        
        $info = array();

        if ($this->form_validation->run() == true) {
            
            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            //var_dump($info);
            //break;
            $info['id'] = $this->medalha_model->adicionar($info);
            
            //$info['user'] = $this->ion_auth->user()->row()->id;
            //$info['accao'] = 'adicionou o toque '.$info['id'].' - '.$info['nome_curto'];
            //$info['agendamento'] = null;
            //$info['ficheiro'] = $info['id'];
            //$info['feriado'] = null;
            //$info['tipo'] = 2;
            //$this->registo_model->log_escreve($info);

            redirect('medalha', 'refresh');

        } else {
            $this->template->load('template', 'medalha/new', $info);
        }
    }
    
    #criar o botao para consulta de logs... quem recebeu medalhas no ultimo ano, e assim...
}

/* End of file medalha.php */
/* Location: ./application/controllers/medalha.php */