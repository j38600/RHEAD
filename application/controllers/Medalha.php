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
        $this->template->load('template', 'medalha/index', $info);
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
        
        //nims dos militares que teem esta medalha
        if ($info['medalha']['nr_militares'] > 0)
        {
            $info['nims'] = $this->medalha_model->ler_nims($info);
            unset($info['id']);
            $nims = $info['nims'];
            
            $cont = 0;
            //var_dump($nims);
            foreach ($nims as $nim)
            {
                $nims[$nim['militar_nim']] =+ $nim['militar_nim'];
                unset($nims[$cont]);
                $cont++;
                
            }
            $info['nims'] = $nims;
            //var_dump($nims);
            
            //militares desta medalha
            $info['militares'] = $this->militar_model->ler($info);
            //var_dump($info['militares']);
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
    Consulta de medalhas não recebidas ou não impostas
    Cartão à esquerda com lista dos militares que já foi pedida a medalha, mas que ainda não recebemos.
        Pode haver militares que já foram impostas, mas ainda não foram recebidas.
    Cartão à direita com lista dos militares que ainda não foram impostas.
        Podem haver militares que ainda não foram recebidas, ou que já foram recebidas.
    Clicando no militar vão para o militar, podendo pedir, receber ou atribuir.
    Clicando na medalha vão para listagem de militares que têm a medalha.
    
    Posso acrescentar um campo checkbox, para no final poder exportar uma lista do pessoal que quero impor medalhas??
    No final tem a possibilidade de exportar as listas, csv/pdf?? 

    Fazer highlight dos militares que já foi imposta, na lista das por receber??
    Fazer highlight dos militares que já foi recebida, na lista a impor??
    @return void
    **/
    public function lista()
    {
        $info=array();
        
        $info['por_receber'] = 1;
        $militares = $this->medalha_model->ler_militar_medalha($info);
        $info['nims_por_receber'] = $militares;
        unset($info['por_receber']);
        
        $info['por_impor'] = 1;
        $militares = $this->medalha_model->ler_militar_medalha($info);
        $info['nims_por_impor'] = $militares;
        unset($info['por_impor']);
        
        $info['proxima_cerimonia'] = 1;
        $militares = $this->medalha_model->ler_militar_medalha($info);
        $info['nims_proxima_cerimonia'] = $militares;
        unset($info['proxima_cerimonia']);
        
        $medalhas = $this->medalha_model->ler($info);
        $info['medalhas'] = $medalhas;
        
        //var_dump($info);
        //break;

        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'medalha/lista', $info);
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
            $this->template->load('template', 'medalha/novo', $info);
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

    /**@
    Atualizar as datas de pedido, rececao e imposicao das medalhas
    @return void
    **/
    public function alterarGDH($nim = '')
    {
        //$this->form_validation->set_rules('GDH', 'Data', 'trim|required');

        //$this->form_validation->run();

        $info = array();
        $post = $this->input->post(null, true);
        
        $info['informacao'] = $post['informacao'];
        $info['med_cond_id'] = $post['medalha'];
        $info['militar_nim'] = $nim;
        
        switch ($post['operacao']) {
            case 'proximacerimonia':
                $info['impor_proxima_cerimonia'] = $post['proxima_cerimonia'] ? '0' : '1';
                $info['resultado'] = $this->medalha_model->atualizar_militar_med_cond($info);
                break;
            case 'pedida':
                $info['data_pedida'] = $post['GDH'];
                $info['pedida'] = 1;
                $stock = $post['stock'];
                break;
            case 'recebida':
                $info['data_recebida'] = $post['GDH'];
                $info['recebida'] = 1;
                $stock = $post['stock']+1;
                break;
            case 'imposta':
                $info['data_imposta'] = $post['GDH'];
                $info['imposta'] = 1;
                $info['impor_proxima_cerimonia'] = 0;
                $stock = $post['stock']-1;
                break;
            case 'informacao':
                $info['resultado'] = $this->medalha_model->atualizar_militar_med_cond($info);
                break;
            default:
                //Á partida entra nas outras. Podia por aqui uma mensagem de erro, talvez...
                break;
        }//se o GDH vier vazio, salta fora sem fazer nada. 
        if (!empty($post['GDH'])) { 
            $info['resultado'] = $this->medalha_model->atualizar_militar_med_cond($info);
            $info['stock'] = $stock;
            $info['res'] = $this->medalha_model->atualizar_stock($info);
        }
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