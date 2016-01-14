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
    @return void
    **/
    public function index()
    {
        $info = array();
        $medalhas = $this->medalha_model->ler($info);
        
        $info['medalhas'] = $medalhas;
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'medalha/list', $info);
    }
    
    /**@
    Consulta de uma medalha. 
    Cartão à esquerda com lista de militares que a têem.
        Clicando vão para:  o militar, podendo pedir, receber ou atribuir.
        No fim da lista, pode adicionar um militar.
            Escolhe de uma dropdown com os nims de todos.
            É direcionado para o mesmo, podendo pedir, receber ou atribuir a mesma.
    Cartão à direita com informações da medalha.
    @return void
    **/
    public function view($id = '')
    {
        //$id da escala
        $info = array();
        $info['id'] = $id;
        $medalha = $this->medalha_model->ler($info);
        $info['medalha'] = $medalha[0];
        
        //nims dos militares que estao nesta escala
        if ($info['medalha']['nr_militares'] > 0)
        {
            $info['nims'] = $this->medalha_model->ler_nims($info);
            unset($info['id']);
            $nims = $info['nims'];
            
            $cont = 0;
            foreach ($nims as $nim)
            {
                $nims[$nim['militar_nim']] =+ $nim['militar_nim'];
                unset($nims[$cont]);
                $cont++;
                
            }
            $info['nims'] = $nims;
            //militares desta escala
            $info['militares'] = $this->militar_model->ler($info);
            unset($info['nims']);
        }
        else 
        {
            $info['militares'] = array();
            unset($info['id']);
        }
        
        //saco todos os militares, para poder atribuir as medalhas.
        $info['todos_militares'] = $this->militar_model->ler($info);
        
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'medalha/view', $info);
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
    
    /**@
    Nova medalha ou condecoração
    @return void
    **/
    public function atribuir()
    {
        $info = array();
        $info = $this->input->post(null, true);
        
        $info['id'] = $this->medalha_model->atribuir($info);
        
        //$info['user'] = $this->ion_auth->user()->row()->id;
        //$info['accao'] = 'adicionou o toque '.$info['id'].' - '.$info['nome_curto'];
        //$info['agendamento'] = null;
        //$info['ficheiro'] = $info['id'];
        //$info['feriado'] = null;
        //$info['tipo'] = 2;
        //$this->registo_model->log_escreve($info);
        
        
        redirect('militar/view/'.$info['militar_nim'], 'refresh');

    }
    
    #criar o botao para consulta de logs... quem recebeu medalhas no ultimo ano, e assim...
}

/* End of file medalha.php */
/* Location: ./application/controllers/medalha.php */