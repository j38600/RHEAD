<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Militar extends CI_Controller {

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
            $this->template->set('title', 'Militares');
            $this->template->set('nav', 'militar');
            $this->template->set('user', $this->ion_auth->user()->row()->username);
            $this->template->set(
                'admin', ($this->ion_auth->is_admin())? true: false
            );
        }
        $this->output->enable_profiler(TRUE);
    }

    /**@
    Listagem de todos os militares
    + campos de filtragem no topo...
    ??cor indica presença em mapa diário??
    <nim | posto | apelido(view) | nome | editar (edit_info_pessoal) >
    botao adicionar normal se for sec pess e for colocado na unidade, 
    botao adicionar adido se for companhia e for colocado como adido.
    @return void
    **/
    public function index()
    {
        $info = array();
        $info['militares'] = $this->militar_model->ler($info);
        //var_dump($info['militares']);
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'militar/list', $info);
    }

    /**@
    Listagem de um militar
    listagem de informação pessoal
    + planeamento de ferias "normais", com linhas por cada periodo, clicavel para as ferias
    + trabalho estudante, se for, com o periodo de aulas,
        e disciplinas inscrito, e numero de dias por disciplina ja gastos.
        clica para ir para o modelo dos trab_estudantes
    + escalas, linha com cada escala, talvez ultimo dia em que fez / nomeado.
        clica e vai para escala.
    @return void
    **/
    public function view($id = '')
    {
        $this->form_validation->set_rules('data', 'Data', 'trim|required');

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

            $info = array();
            $info['id'] = $id;
            $militar = $this->militar_model->ler($info);
            $medalhas = $this->medalha_model->ler_militar($info);
            $info['militar'] = $militar[0];
            $info['medalhas'] = $medalhas;
            var_dump($info);
        }
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'militar/view', $info);
    }

    /**@
    Edição de informação pessoal de um militar
    Edição dos campos pessoais do militar. 
    Implica arquivo / digitalização de documentção para justificar...
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
    Histórico dos militares!!!
    Métricas dos militares, por categorias, por anos, companhias, especialidades, etc, etc, etc
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
        $this->form_validation->set_rules('nome_curto', 'Nome Curto', 'trim|max_length[50]|required');
        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');

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
}

/* End of file militar.php */
/* Location: ./application/controllers/militar.php */