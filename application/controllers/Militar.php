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
        $info = array();
        $info['id'] = $id;
        $militar = $this->militar_model->ler($info);
        $medalhas = $this->medalha_model->ler_militar($info);
        $info['militar'] = $militar[0];
        $info['medalhas'] = $medalhas;
        
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
    /**public function history($id = '')
    {
        $info = array();
        $info['id'] = $id;
        $emissor = $this->emitter_model->ler($info);
        $info['emissor'] = $emissor[0];
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'emitter/view', $info);
    }**/

    /**@
    Novo militar
    @return void
    **/
    public function novo()
    {
        $this->form_validation->set_rules('nim', 'Número de Indentificação Militar', 'trim|required');
        $this->form_validation->set_rules('nome', 'Nome Completo', 'trim|required');
        $this->form_validation->set_rules('apelido', 'Apelido', 'trim|required');
        $this->form_validation->set_rules('antiguidade', 'Antiguidade', 'trim|required');
        $this->form_validation->set_rules('nota_curso', 'Nota de Curso', 'trim|required');
        //$this->form_validation->set_rules('ativo', 'Descrição', 'trim|required');
        //$this->form_validation->set_rules('posto_id', 'Descrição', 'trim|required');
        //$this->form_validation->set_rules('quartel_id', 'Descrição', 'trim|required');
        //$this->form_validation->set_rules('companhia_id', 'Descrição', 'trim|required');

        $info = array();
        $postos_bd = $this->militar_model->ler_postos($info);
        $quarteis_bd = $this->militar_model->ler_quarteis($info);
        $companhias_bd = $this->militar_model->ler_companhias($info);

        $postos=array();
        $quarteis=array();
        $companhias=array();

        foreach($postos_bd as $posto){
            $postos[$posto['id']] = $posto['posto'];
            }
        $postos = array('0' => 'Outra opção') + $postos;
        foreach($quarteis_bd as $quartel){
            $quarteis[$quartel['id']] = $quartel['quartel'];
            }
        $quarteis = array('0' => 'Outra opção') + $quarteis;
        foreach($companhias_bd as $companhia){
            $companhias[$companhia['id']] = $companhia['companhia'];
            }
        $companhias = array('0' => 'Outra opção') + $companhias;
        $info['postos'] = $postos;
        $info['quarteis'] = $quarteis;
        $info['companhias'] = $companhias;

        if ($this->form_validation->run() == true) {
            
            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            //o valor que vem no post, é o do indice. aqui vou buscar o nome do ficheiro
            $info['ativo'] = true;
            $info['id'] = $this->militar_model->adicionar($info);
            
            //$info['user'] = $this->ion_auth->user()->row()->id;
            //$info['accao'] = 'adicionou o toque '.$info['id'].' - '.$info['nome_curto'];
            //$info['agendamento'] = null;
            //$info['ficheiro'] = $info['id'];
            //$info['feriado'] = null;
            //$info['tipo'] = 2;
            //$this->registo_model->log_escreve($info);

            redirect('militar', 'refresh');

        } else {
            $this->template->load('template', 'militar/novo', $info);
        }
    }
}

/* End of file militar.php */
/* Location: ./application/controllers/militar.php */