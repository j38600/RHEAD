<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Escala extends CI_Controller {

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
            $this->template->set('title', 'Escalas');
            $this->template->set('nav', 'escala');
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
    Listagem de escalas existentes
    <nome da escala | Nr militares | Consultar escala(view) | Previsao (previsao)>
    @return void
    **/
    public function index()
    {
        unset($info);
        $info = array();
        
        $escalas = $this->escala_model->ler($info);
        
        //$info['nr_militares_escalas'] = 1;
        //$nr_militares_p_escala = $this->escala_model->ler($info);
        
        
        $info['escalas'] = $escalas;
        $info['permissoes'] = $this->user_group;
        $this->template->load('template', 'escala/list', $info);
    }

    /**@
    Consulta de uma escala. 
    Diversas opções da mesma(semana, fim de semana, 24h ou inicio e fim, etc.)
    + lista dos militares por antiguidades.
        Clicando podemos ver último serviço, se for trab-estudante, podemos ver período semanal??
        Podemos colorir, para saber se está disponivel, ou se é trabalhador-estudante.
        Podemos obter lista dos próximos 2ou 3 períodos de indisponibilidades
    + botão para ver previsão da escala.
    @return void
    public function view($id = '')
    {
        //$id da escala
        $info = array();
        $info['id'] = $id;
        $escala = $this->escala_model->ler($info);
        $info['escala'] = $escala[0];
        //nims dos militares que estao nesta escala
        if ($info['escala']['nr_militares'] > 0)
        {
            $info['nims'] = $this->escala_model->ler_nims($info);
            unset($info['id']);
            $nims = $info['nims'];
            $cont = 0;
            foreach ($nims as $nim)
            {
                $nims[$nim['militares_nim']] =+ $nim['militares_nim'];
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
        var_dump($info);
        //break;
        $info['permissoes'] = $this->user_group;
        $this->template->load('template', 'escala/view', $info);
    }
**/
    
    /**@
    Vista de uma escala. 
    Diversas opções da mesma(semana, fim de semana, 24h ou inicio e fim, etc.)
    + lista dos militares da mesma, com informação de disponibilidade dos mesmos.
    @return void
    public function edit($id = '')
    {
        $info = array();
        $info['id'] = $id;
        $emissor = $this->emitter_model->ler($info);
        $info['emissor'] = $emissor[0];
        $info['permissoes'] = $this->user_group;
        $this->template->load('template', 'emitter/view', $info);
    }
**/
    
    /**@
    Histórico das escalas!!!
    Por anos, botar estatisticas aki
    @return void
    public function history($id = '')
    {
        $info = array();
        $info['id'] = $id;
        $emissor = $this->emitter_model->ler($info);
        $info['emissor'] = $emissor[0];
        $info['permissoes'] = $this->user_group;
        $this->template->load('template', 'emitter/view', $info);
    }
**/
    /**@
    Nova escala
    @return void
    **/
    public function nova()
    {
        //$permissoes = $this->user_group;
        //if (!$permissoes['secpess']) {
        //    redirect('medalha', 'refresh');
        //}
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        
        $info = array();

        if ($this->form_validation->run() == true) {
            
            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);

            $info['id'] = $this->escala_model->adicionar($info);
            
            //crio os campos que vou usar para fazer o log.
            //$info['user_nim'] = $this->ion_auth->user()->row()->username;
            //$info['tipo'] = 'medalhas';
            //$info['accao'] = 'nova';
            //$info['informacao'] = 'nome: '.$info['nome'].'; descrição: '.$info['descricao'];
            //$this->registo_model->log_escreve($info);
            
            redirect('escala', 'refresh');

        } else {

            $info['permissoes'] = $this->user_group;
            $this->template->load('template', 'escala/nova', $info);
        }
    }
}

/* End of file escala.php */
/* Location: ./application/controllers/escala.php */