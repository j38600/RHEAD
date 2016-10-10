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
        $this->output->enable_profiler(TRUE);
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
    + lista dos militares.
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
        //saco todos os militares, para poder nomea-los às atividades.
        $info['todos_militares'] = $this->militar_model->ler($info);
        
        $info['permissoes'] = $this->user_group;
        $this->template->load('template', 'escala/view', $info);
    }
    
    /**@
    Editar a escala
    @return void
    **/
    public function edit($id = '')
    {
        //$permissoes = $this->user_group;
        //if (!$permissoes['secpess'] && !$permissoes['sois']) {
        //    redirect('atividade', 'refresh');
        //}
        $info = array();

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        
        $info['id'] = $id;
        $escala = $this->escala_model->ler($info);
        $info['escala'] = $escala[0];
        if ($this->form_validation->run() == true) {

            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            //o valor que vem no post, é o do indice. aqui vou buscar o nome do ficheiro

            $this->escala_model->atualizar($info);

            //crio os campos que vou usar para fazer o log.
            //$info['user_nim'] = $this->ion_auth->user()->row()->username;
            //$info['tipo'] = 'atividades';
            //$info['accao'] = 'atualizar';
            //$info['informacao'] = 'descrição: '.$info['descricao'].'; de: '.$info['de'].'; ate: '.$info['ate'].
            //    '; Secção Bipbip: b|'.$info['bipbip_id'].
            //    '; quartel: q|'.$info['quarteis_id'].'; Secção Anuário: a|'.$info['anuario_id'];

            //$this->registo_model->log_escreve($info);

            redirect('escala/view/'.$info['id'], 'refresh');

        } else {
            $info['permissoes'] = $this->user_group;

            $this->template->load('template', 'escala/editar', $info);
        }
    }
    
    /**@
    Cria entrada na tabela intermédia militars <=> escalas
    @return void
    **/
    public function associar()
    {
        $permissoes = $this->user_group;
        if (!$permissoes['secpess']) {
            redirect('atividade', 'refresh');
        }
        $info = array();
        $info = $this->input->post(null, true);
        
        if ($info['gdh_ultimo'] == '') {
            unset($info['gdh_ultimo']);
        }
        $info['id'] = $this->escala_model->associar($info);
        
        //crio os campos que vou usar para fazer o log.
        //$info['user_nim'] = $this->ion_auth->user()->row()->username;
        //$info['tipo'] = 'medalhas';
        //$info['accao'] = 'atribuir';
        //$info['informacao'] = 'nim condecorado: '.$info['militar_nim'].'; medalha: m|'.$info['med_cond_id'];
        //$this->registo_model->log_escreve($info);
        
        redirect('escala/view/'.$info['escala_id'], 'refresh');
    }

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

    /**@
    Controller das dispensas.  
    Recebe duas variaveis, $action e $id.
    @return void
    **/
    public function dispensa($action = '', $id = '')
    {
        //$action -> ação a tomar.
        //se for list, nao recebe $id.
        //$id da dispensa
        switch ($action) {
            case 'list':
                unset($info);
                $info = array();
                
                $dispensas = $this->escala_model->ler_dispensa($info);
                
                $info['dispensas'] = $dispensas;
                $info['permissoes'] = $this->user_group;
                $this->template->load('template', 'escala/dispensa_list', $info);

                break;
            case 'view':
                unset($info);
                $info = array();
                $info['id'] = $id;
                $dispensa = $this->escala_model->ler_dispensa($info);
                
                $info['dispensa'] = $dispensa[0];
                //nims dos militares que estao dispensados
                if ($info['dispensa']['nr_militares'] > 0)
                {
                    $info['nims'] = $this->escala_model->ler_nims_dispensa($info);
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
                    //militares desta dispensa
                    $info['militares'] = $this->militar_model->ler($info);
                    unset($info['nims']);
                }
                else 
                {
                    $info['militares'] = array();
                    unset($info['id']);
                }
                //saco todos os militares, para poder nomea-los às atividades.
                $info['todos_militares'] = $this->militar_model->ler($info);
                
                $info['permissoes'] = $this->user_group;
                $this->template->load('template', 'escala/dispensa_view', $info);

                break;
            case 'associar':
                
                unset($info);
                $info = array();
                $info = $this->input->post(null, true);
                
                $info['id'] = $this->escala_model->associar_dispensa($info);
                
                //crio os campos que vou usar para fazer o log.
                //$info['user_nim'] = $this->ion_auth->user()->row()->username;
                //$info['tipo'] = 'medalhas';
                //$info['accao'] = 'atribuir';
                //$info['informacao'] = 'nim condecorado: '.$info['militar_nim'].'; medalha: m|'.$info['med_cond_id'];
                //$this->registo_model->log_escreve($info);
                
                redirect('escala/dispensa/view/'.$info['indisponibilidade_id'], 'refresh');
                break;
            case 'edit':
                echo($action);
                break;
            case 'nova':
                
                $this->form_validation->set_rules('gdh_inicio', 'GDH Início', 'trim|required');
                $this->form_validation->set_rules('gdh_fim', 'GDH Fim', 'trim|required');

                unset($info);
                $info = array();

                $razoes_bd = $this->escala_model->ler_razoes($info);
                $razoes=array();
                foreach($razoes_bd as $razao){
                    $razoes[$razao['id']] = $razao['razao'];
                }

                if ($this->form_validation->run() == true) {
                    
                    unset($info);
                    $info = array();
                    $info = $this->input->post(null, true);
                    unset($info['submit']);

                    $info['id'] = $this->escala_model->adicionar_dispensa($info);
                    
                    //crio os campos que vou usar para fazer o log.
                    //$info['user_nim'] = $this->ion_auth->user()->row()->username;
                    //$info['tipo'] = 'medalhas';
                    //$info['accao'] = 'nova';
                    //$info['informacao'] = 'nome: '.$info['nome'].'; descrição: '.$info['descricao'];
                    //$this->registo_model->log_escreve($info);
                    
                    redirect('escala/dispensa/list', 'refresh');

                } else {

                    $info['razoes'] = $razoes;

                    $info['permissoes'] = $this->user_group;
                    $this->template->load('template', 'escala/dispensa_nova', $info);
                }
                break;
            default:
                redirect('escala/dispensa/list', 'refresh');
                break;
        }
    }
    
    /**@
    Controller das previsoes.
    @return void
    **/
    public function previsao($id = '')
    {
    }
    
}

/* End of file escala.php */
/* Location: ./application/controllers/escala.php */