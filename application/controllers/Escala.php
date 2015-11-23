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
        }
        $this->output->enable_profiler(TRUE);
    }

    /**@
    Listagem de escalas existentes
    + # de militares por escala
    <nome da escala | # militares | Consultar escala(view) | Editar (edit)>
    @return void
    **/
    public function index()
    {
        $info = array();
        $escalas = $this->escala_model->ler($info);
        
        //$info['nr_militares_escalas'] = 1;
        //$nr_militares_p_escala = $this->escala_model->ler($info);
        
        
        $info['escalas'] = $escalas;
        var_dump($escalas);
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'escala/list', $info);
    }

    /**@
    Vista de uma escala. 
    Diversas opções da mesma(semana, fim de semana, 24h ou inicio e fim, etc.)
    + lista dos militares da mesma, com informação de disponibilidade dos mesmos.
    @return void
    **/
    public function edit($id = '')
    {
        $info = array();
        $info['id'] = $id;
        $emissor = $this->emitter_model->ler($info);
        $info['emissor'] = $emissor[0];
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'emitter/view', $info);
    }

    /**@
    Consulta de uma escala. 
    Diversas opções da mesma(semana, fim de semana, 24h ou inicio e fim, etc.)
    + lista de nomeação dos militares, clicando, vê-se os mais folgados, e as razões de não nomeação.
    + opção de validar nomeação para aquele dia??
    @return void
    **/
    public function view($id = '')
    {
        $info = array();
        $info['id'] = $id;
        $emissor = $this->emitter_model->ler($info);
        $info['emissor'] = $emissor[0];
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'emitter/view', $info);
    }

    /**@
    Histórico das escalas!!!
    Por anos, botar estatisticas aki
    @return void
    **/
    public function history($id = '')
    {
        $info = array();
        $info['id'] = $id;
        $emissor = $this->emitter_model->ler($info);
        $info['emissor'] = $emissor[0];
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'emitter/view', $info);
    }

    public function novo()
    {
        $this->form_validation->set_rules('nome_curto', 'Nome Curto', 'trim|max_length[50]|required|xss_clean');
        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|xss_clean');

        //$info['pasta'] = scandir(LOCALIZACAO_TOQUES);
    
        if ($this->form_validation->run() == true) {
            
            //guardo o array com o conteudo da pasta, e o indice do ficheiro no array
            $pasta = $info['pasta'];
            $ficheiro = $this->input->post('nome_ficheiro');

            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            //o valor que vem no post, é o do indice. aqui vou buscar o nome do ficheiro
            $info['nome_ficheiro'] = $pasta[$ficheiro];
            $info['ativo'] = true;
            $info['id'] = $this->clarim_model->adicionar($info);
            
            $info['user'] = $this->ion_auth->user()->row()->id;
            $info['accao'] = 'adicionou o toque '.$info['id'].' - '.$info['nome_curto'];
            $info['agendamento'] = null;
            $info['ficheiro'] = $info['id'];
            $info['feriado'] = null;
            $info['tipo'] = 2;
            $this->registo_model->log_escreve($info);

            redirect('clarim', 'refresh');

        } else {
            $this->template->load('template', 'emitter/new', $info);
        }
    }

    public function map()
    {
        $config['zoom'] = 'auto';
        $config['cluster'] = TRUE;
        $this->googlemaps->initialize($config);
        
        $info = array();
        $emissores = $this->emitter_model->ler($info);
        
        foreach ($emissores as $emissor){
            $marker = array();
            $marker['position'] = $emissor['lat'].', '.$emissor['lon'];
            $this->googlemaps->add_marker($marker);
        }
        
        $data = array();
        $data['map'] = $this->googlemaps->create_map();
        $data['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'emitter/map', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/incident.php */