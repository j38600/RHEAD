<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Atividade extends CI_Controller {

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
            $this->template->set('title', 'Atividades do aquartelamento');
            $this->template->set('nav', 'atividades');
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
    Listagem de atividades.
    @return void
    **/
    public function index()
    {
        unset($info);
        $info = array();
        
        $bipbip_bd = $this->atividade_model->ler_bipbip($info);
        $anuario_bd = $this->atividade_model->ler_anuario($info);

        $bipbips=array();
        $bipbips[0]='Todas';

        $anuarios=array();
        $anuarios[0]='Todas';

        $canceladas=array();
        $canceladas[2]='Todas';
        $canceladas[1]='Sim';
        $canceladas[0]='Não';

        foreach($bipbip_bd as $bipbip){
            $bipbips[$bipbip['id']] = $bipbip['seccao'];
        }

        foreach($anuario_bd as $anuario){
            $anuarios[$anuario['id']] = $anuario['seccao'];
        }
        
        $info = $this->input->post(null, true);
        
        $atividades = $this->atividade_model->ler($info);
        
        $info['atividades'] = $atividades;
        $info['permissoes'] = $this->user_group;

        $info['bipbips'] = $bipbips;
        $info['anuarios'] = $anuarios;
        $info['canceladas'] = $canceladas;

        $this->template->load('template', 'atividade/lista', $info);
    }
    
    /**@
    Cartão à esquerda com lista de militares envolvidos.
        Clicando vão para o militar.
        No fim da lista, pode adicionar um militar.
            Escolhe de uma dropdown com os nims de todos.
            É direcionado para o mesmo, podendo pedir, receber ou atribuir a mesma.
    Cartão à direita com informações da atividade. Aqui podem editá-la.
    @return void
    **/
    public function view($id = '')
    {
        //$id da atividade
        $info = array();
        $info['id'] = $id;
        
        //variavel para ser usada no modelo.
        $info['view'] = array();

        $atividade = $this->atividade_model->ler($info);
        $info['atividade'] = $atividade[0];
        //var_dump($info);
        //break;
        //nims dos militares que estiveram envolvidos nesta atividade
        if ($info['atividade']['nr_militares'] > 0)
        {
            $info['nims'] = $this->atividade_model->ler_nims($info);
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
            
            //militares desta medalha
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
        $this->template->load('template', 'atividade/view', $info);
    }

    /**@
    Cria entrada na tabela intermédia militars <=> atividades
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
        
        $info['id'] = $this->atividade_model->associar($info);
        
        //crio os campos que vou usar para fazer o log.
        //$info['user_nim'] = $this->ion_auth->user()->row()->username;
        //$info['tipo'] = 'medalhas';
        //$info['accao'] = 'atribuir';
        //$info['informacao'] = 'nim condecorado: '.$info['militar_nim'].'; medalha: m|'.$info['med_cond_id'];
        //$this->registo_model->log_escreve($info);
        
        redirect('atividade/view/'.$info['atividade_id'], 'refresh');
    }

    /**@
    Nova atividade
    @return void
    **/
    public function nova()
    {
        $permissoes = $this->user_group;
        if (!$permissoes['secpess'] && !$permissoes['sois']) {
            redirect('atividade', 'refresh');
        }
        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');
        
        $info = array();

        $bipbip_bd = $this->atividade_model->ler_bipbip($info);
        $quarteis_bd = $this->militar_model->ler_quarteis($info);
        $anuario_bd = $this->atividade_model->ler_anuario($info);

        $bipbips=array();
        $quarteis=array();
        $anuarios=array();

        foreach($bipbip_bd as $bipbip){
            $bipbips[$bipbip['id']] = $bipbip['seccao'];
            }
        
        foreach($quarteis_bd as $quartel){
            $quarteis[$quartel['id']] = $quartel['quartel'];
            }
        
        foreach($anuario_bd as $anuario){
            $anuarios[$anuario['id']] = $anuario['seccao'];
            }
        
        if ($this->form_validation->run() == true) {
            
            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            
            $info['id'] = $this->atividade_model->adicionar($info);
            
            //crio os campos que vou usar para fazer o log.
            $info['user_nim'] = $this->ion_auth->user()->row()->username;
            $info['tipo'] = 'atividades';
            $info['accao'] = 'criar';
            $info['informacao'] = 'descrição: '.$info['descricao'].'; de: '.$info['de'].'; ate: '.$info['ate'].
                '; Secção Bipbip: b|'.$info['bipbip_id'].
                '; quartel: q|'.$info['quarteis_id'].'; Secção Anuário: a|'.$info['anuario_id'];
            
            $this->registo_model->log_escreve($info);

            redirect('atividade', 'refresh');

        } else {
            $info['permissoes'] = $this->user_group;

            $info['bipbips'] = $bipbips;
            $info['quarteis'] = $quarteis;
            $info['anuarios'] = $anuarios;

            $this->template->load('template', 'atividade/novo', $info);
        }
    }

    /**@
    Edição de atividades.
    Se mudar o nome, datas dos apoios, podem vir aki.
    Se cancelarem, desaparecem da lista, mas nao da db. 
    @return void
    **/
    public function edit($id = '')
    {
        $permissoes = $this->user_group;
        if (!$permissoes['secpess'] && !$permissoes['sois']) {
            redirect('atividade', 'refresh');
        }
        $info = array();

        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');

        $bipbip_bd = $this->atividade_model->ler_bipbip($info);
        $quarteis_bd = $this->militar_model->ler_quarteis($info);
        $anuario_bd = $this->atividade_model->ler_anuario($info);

        $bipbips=array();
        $quarteis=array();
        $anuarios=array();

        foreach($bipbip_bd as $bipbip){
            $bipbips[$bipbip['id']] = $bipbip['seccao'];
            }

        foreach($quarteis_bd as $quartel){
            $quarteis[$quartel['id']] = $quartel['quartel'];
            }

        foreach($anuario_bd as $anuario){
            $anuarios[$anuario['id']] = $anuario['seccao'];
            }

        $info['id'] = $id;
        $atividade = $this->atividade_model->ler($info);
        $info['atividade'] = $atividade[0];

        if ($this->form_validation->run() == true) {

            unset($info);
            $info = array();
            $info = $this->input->post(null, true);
            unset($info['submit']);
            //o valor que vem no post, é o do indice. aqui vou buscar o nome do ficheiro

            $this->atividade_model->atualizar($info);

            //crio os campos que vou usar para fazer o log.
            $info['user_nim'] = $this->ion_auth->user()->row()->username;
            $info['tipo'] = 'atividades';
            $info['accao'] = 'atualizar';
            $info['informacao'] = 'descrição: '.$info['descricao'].'; de: '.$info['de'].'; ate: '.$info['ate'].
                '; Secção Bipbip: b|'.$info['bipbip_id'].
                '; quartel: q|'.$info['quarteis_id'].'; Secção Anuário: a|'.$info['anuario_id'];

            $this->registo_model->log_escreve($info);

            redirect('atividade/view/'.$info['id'], 'refresh');

        } else {
            $info['permissoes'] = $this->user_group;

            $info['bipbips'] = $bipbips;
            $info['quarteis'] = $quarteis;
            $info['anuarios'] = $anuarios;

            $this->template->load('template', 'atividade/editar', $info);
        }
    }
}

/* End of file medalha.php */
/* Location: ./application/controllers/medalha.php */