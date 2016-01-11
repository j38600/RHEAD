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
        
        var_dump($escalas);
        //break;
        //$info['nr_militares_escalas'] = 1;
        //$nr_militares_p_escala = $this->escala_model->ler($info);
        
        
        $info['escalas'] = $escalas;
        $info['admin'] = $this->ion_auth->is_admin();
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
    **/
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
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'escala/view', $info);
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