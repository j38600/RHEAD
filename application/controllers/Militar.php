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
            $this->user_group['sois'] = $this->ion_auth->in_group('SOIS');
            $this->user_group['secpess'] = $this->ion_auth->in_group('SecPess');
            $this->user_group['admin'] = $this->ion_auth->is_admin();
        }
        //$this->output->enable_profiler(TRUE);
    }

    /**@
    Listagem de todos os militares
    + campos de filtragem no topo...
    <nim | posto | apelido(view) | nome | editar (edit_info_pessoal) >
    botao adicionar normal se for sec pess e for colocado na unidade, 
    botao adicionar adido se for companhia e for colocado como adido.
    @return void
    **/
    public function index()
    {
        unset($info);
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
        $postos = array('' => 'Todos') + $postos;
        foreach($quarteis_bd as $quartel){
            $quarteis[$quartel['id']] = $quartel['quartel'];
            }
        $quarteis = array('0' => 'Outra opção') + $quarteis;
        $quarteis = array('' => 'Todos') + $quarteis;
        foreach($companhias_bd as $companhia){
            $companhias[$companhia['id']] = $companhia['companhia'];
            }
        $companhias = array('0' => 'Outra opção') + $companhias;
        $companhias = array('' => 'Todas') + $companhias;
        
        $info = $this->input->post(null, true);
        
        $info['postos'] = $postos;
        $info['quarteis'] = $quarteis;
        $info['companhias'] = $companhias;

        $info['permissoes'] = $this->user_group;
        $info['militares'] = $this->militar_model->ler($info);
        
        //var_dump($info);
        
        $this->template->load('template', 'militar/lista', $info);
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
        $atividades = $this->atividade_model->ler_militar($info);
        $info['militar'] = $militar[0];
        $info['medalhas'] = $medalhas;
        $info['atividades'] = $atividades;
        $info['nr_atividades'] = count($atividades);
        $info['permissoes'] = $this->user_group;
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
        $permissoes = $this->user_group;
        if (!$permissoes['secpess']) {
            redirect('militar', 'refresh');
        }
        $info = array();
        
        $this->form_validation->set_rules('nim', 'Número de Indentificação Militar', 'trim|required');
        $this->form_validation->set_rules('nome', 'Nome Completo', 'trim|required');
        $this->form_validation->set_rules('apelido', 'Apelido', 'trim|required');
        $this->form_validation->set_rules('data_promocao', 'Data de Promoção', 'trim|required');
        $this->form_validation->set_rules('nota_curso', 'Nota de Curso', 'trim|required');
        
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
        
        $info['id'] = $id;
        $militar = $this->militar_model->ler($info);
        $info['militar'] = $militar[0];

        if ($this->form_validation->run() == true) {
            
            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            //o valor que vem no post, é o do indice. aqui vou buscar o nome do ficheiro
            //$info['ativo'] = true;
            $this->militar_model->atualizar($info);
            
            //crio os campos que vou usar para fazer o log.
            $info['user_nim'] = $this->ion_auth->user()->row()->username;
            $info['tipo'] = 'militares';
            $info['accao'] = 'editar';
            $info['informacao'] = 'nim: '.$info['nim'].'; nome: '.$info['nome'].'; apelido: '.$info['apelido'].
                '; posto: p|'.$info['posto_id'].'; antiguidade: '.$info['antiguidade'].'; nota curso: '.$info['nota_curso'].
                '; quartel: q|'.$info['quartel_id'].'; companhia: c|'.$info['companhia_id'];
            $this->registo_model->log_escreve($info);

            redirect('militar/view/'.$info['nim'], 'refresh');

        } else {
            $info['permissoes'] = $this->user_group;
            
            $info['postos'] = $postos;
            $info['quarteis'] = $quarteis;
            $info['companhias'] = $companhias;

            $this->template->load('template', 'militar/editar', $info);
        }

    }

    /**@
    Novo militar
    @return void
    **/
    public function novo()
    {
        $permissoes = $this->user_group;
        if (!$permissoes['secpess']) {
            redirect('militar', 'refresh');
        }
        $this->form_validation->set_rules('nim', 'Número de Indentificação Militar', 'trim|required');
        $this->form_validation->set_rules('nome', 'Nome Completo', 'trim|required');
        $this->form_validation->set_rules('apelido', 'Apelido', 'trim|required');
        $this->form_validation->set_rules('antiguidade', 'Antiguidade', 'trim|required');
        $this->form_validation->set_rules('nota_curso', 'Nota de Curso', 'trim|required');
        
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
        
        if ($this->form_validation->run() == true) {
            
            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            //o valor que vem no post, é o do indice. aqui vou buscar o nome do ficheiro
            $info['ativo'] = true;
            $this->militar_model->adicionar($info);
            
            //crio os campos que vou usar para fazer o log.
            $info['user_nim'] = $this->ion_auth->user()->row()->username;
            $info['tipo'] = 'militares';
            $info['accao'] = 'criar';
            $info['informacao'] = 'nim: '.$info['nim'].'; nome: '.$info['nome'].'; apelido: '.$info['apelido'].
                '; posto: p|'.$info['posto_id'].'; antiguidade: '.$info['antiguidade'].'; nota curso: '.$info['nota_curso'].
                '; quartel: q|'.$info['quartel_id'].'; companhia: c|'.$info['companhia_id'];
            $this->registo_model->log_escreve($info);

            redirect('militar', 'refresh');

        } else {
            $info['permissoes'] = $this->user_group;
            
            $info['postos'] = $postos;
            $info['quarteis'] = $quarteis;
            $info['companhias'] = $companhias;

            $this->template->load('template', 'militar/novo', $info);
        }
    }
}

/* End of file militar.php */
/* Location: ./application/controllers/militar.php */