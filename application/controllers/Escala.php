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
    Compara as datas do ultimo serviço feito, para ordenar os militares consoante a folga.
    @return int
    **/
    private function _compara_data($a, $b)
    {
        $t1 = strtotime($a['gdh_ultimo']);
        $t2 = strtotime($b['gdh_ultimo']);
        return $t1 - $t2;
    }

    /**@
    Diz-me se é dia de semana ou fdsemana e/ou feriado
    @return Bool
    **/
    private function _fim_de_semana($data, $feriados)
    {   
        $resultado = FALSE;
        foreach ($feriados as $feriado)
            {
                if (date('Y-m-d', strtotime($feriado['data'])) == $data)
                {
                    $resultado = TRUE;
                }
            }
        $resultado = (date('N', strtotime($data)) >= 6) || $resultado;

        return($resultado);
    }

    /**@
    Recebe uma lista de militares, e separa os que estão dispensados e os que não estão
    @return array
    **/
    private function _separa_dispensados($data, $militares, $dispensas)
    {   
        $resultado = array();
        $dispensados = array();
        $razoes = array();
        //$cont = 0;
        foreach ($dispensas as $dispensa)
        {
            //dispensas para este dia inclusive
            $comeca = (date('Y-m-d H:i', strtotime($dispensa['gdh_inicio'])) <= $data);
            $acaba = ($data <= date('Y-m-d H:i', strtotime($dispensa['gdh_fim'])));
            //var_dump($data);

            if ($comeca && $acaba)
            {
                //tiro o militar com este nim da lista dos militares, e ponho na lista dos dispensados.
                $key = array_search($dispensa['militar_nim'], array_column($militares, 'nim'));
                $dispensados[] = $militares[$key];
                $razoes[] = $dispensa;
                unset($militares[$key]);
            }
        }
        $resultado['dispensados'] = $dispensados;
        $resultado['nomeaveis'] = $militares;
        $resultado['razoes'] = $razoes;

        return($resultado);
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
                $nims[$nim['militar_nim']] = $nim['militar_nim'];
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
        
        //vejo se há trocas ou destrocas, para esta escala.
        $trocas = $this->escala_model->ler_trocas($info);
        $info['trocas'] = $trocas;
        
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
            $info['hora_inicio'] = date('Y-m-d H:i:s', strtotime($info['hora_inicio']));
            $info['hora_fim'] = date('Y-m-d H:i:s', strtotime($info['hora_fim']));
            
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
            $info['hora_inicio'] = date('Y-m-d H:i:s', strtotime($info['hora_inicio']));
            $info['hora_fim'] = date('Y-m-d H:i:s', strtotime($info['hora_fim']));

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
                if(empty($dispensa)){
                    redirect('escala/dispensa/list', 'refresh');
                }
                
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
                        $nims[$nim['militar_nim']] = $nim['militar_nim'];
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
                $this->form_validation->set_rules('gdh_inicio', 'GDH Início', 'trim|required');
                $this->form_validation->set_rules('gdh_fim', 'GDH Fim', 'trim|required');
                
                unset($info);
                $info = array();
                
                $razoes_bd = $this->escala_model->ler_razoes($info);
                $razoes=array();
                
                $info['id'] = $id;
                $dispensa = $this->escala_model->ler_dispensa($info);
                if(empty($dispensa)){
                    redirect('escala/dispensa/list', 'refresh');
                }

                $info['dispensa'] = $dispensa[0];
                
                foreach($razoes_bd as $razao){
                    $razoes[$razao['id']] = $razao['razao'];
                }
                if ($this->form_validation->run() == true) {

                    unset($info);
                    $info = array();
                    $info = $this->input->post(null, true);
                    unset($info['submit']);
                    
                    $this->escala_model->atualizar_dispensa($info);

                    //crio os campos que vou usar para fazer o log.
                    //$info['user_nim'] = $this->ion_auth->user()->row()->username;
                    //$info['tipo'] = 'atividades';
                    //$info['accao'] = 'atualizar';
                    //$info['informacao'] = 'descrição: '.$info['descricao'].'; de: '.$info['de'].'; ate: '.$info['ate'].
                    //    '; Secção Bipbip: b|'.$info['bipbip_id'].
                    //    '; quartel: q|'.$info['quarteis_id'].'; Secção Anuário: a|'.$info['anuario_id'];

                    //$this->registo_model->log_escreve($info);

                    redirect('escala/dispensa/view/'.$info['id'], 'refresh');

                } else {
                    $info['razoes'] = $razoes;
                    $info['permissoes'] = $this->user_group;

                    $this->template->load('template', 'escala/dispensa_editar', $info);
                }
                
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
    Controller dos feriados
    Recebe duas variaveis, $action e $id.
    @return void
    **/
    public function feriado($action = '', $id = '')
    {
        switch ($action) {
            case 'list':
                unset($info);
                $info = array();
                if($id=='erro'){
                    $info['erro'] = '';
                }
                $feriados = $this->escala_model->ler_feriado($info);
                
                $info['feriados'] = $feriados;
                $info['permissoes'] = $this->user_group;
                $this->template->load('template', 'escala/feriado_list', $info);

                break;
            case 'novo':
                $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
                $this->form_validation->set_rules('data', 'Data', 'trim|required');

                if ($this->form_validation->run() == true) {

                    $info = $this->input->post(null, true);
                    //Por enquanto, o quartel fica fixo no RTm. De futuro, fazer o seguinte:
                    //ir buscar o username do Ion Auth, que é o nim, procurar na bd pelo nim,
                    //Sacar o id do aurtel e passá-lo para a variável.
                    $info['quartel_id'] = 1;
                    $info['id'] = $this->escala_model->adicionar_feriado($info);
                    redirect('escala/feriado/list', 'refresh');
                } else {
                    $info['permissoes'] = $this->user_group;
                    redirect('escala/feriado/list/erro', 'refresh');
                }
            
                break;
            case 'update':
                
                $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
                $this->form_validation->set_rules('data', 'Data', 'trim|required');

                if ($this->form_validation->run() == true) {

                    $info = $this->input->post(null, true);
                    $info['id'] = $this->escala_model->atualizar_feriado($info);
                    $info['data'] = date('Y-m-d H:i:s', strtotime($info['data']));

                    redirect('escala/feriado/list', 'refresh');
                } else {
                    $info['permissoes'] = $this->user_group;
                    redirect('escala/feriado/list/erro', 'refresh');
                }
            
                break;
            default:
                redirect('escala/feriado/list', 'refresh');
                break;
        }
    }

    /**@
    Controller das razoes
    Recebe duas variaveis, $action e $id.
    @return void
    **/
    public function razao($action = '', $id = '')
    {
        switch ($action) {
            case 'list':
                unset($info);
                $info = array();
                if($id=='erro'){
                    $info['erro'] = '';
                }
                $razoes = $this->escala_model->ler_razoes($info);
                
                $info['razoes'] = $razoes;
                $info['permissoes'] = $this->user_group;
                $this->template->load('template', 'escala/razao_list', $info);

                break;
            case 'nova':
                $this->form_validation->set_rules('razao', 'Razão', 'trim|required');
                
                if ($this->form_validation->run() == true) {

                    $info = $this->input->post(null, true);
                    $info['id'] = $this->escala_model->adicionar_razao($info);
                    redirect('escala/razao/list', 'refresh');
                } else {
                    $info['permissoes'] = $this->user_group;
                    redirect('escala/razao/list/erro', 'refresh');
                }
            
                break;
            case 'update':
                
                $this->form_validation->set_rules('razao', 'Razão', 'trim|required');
                
                if ($this->form_validation->run() == true) {

                    $info = $this->input->post(null, true);
                    $info['id'] = $this->escala_model->atualizar_razao($info);
                    
                    redirect('escala/razao/list', 'refresh');
                } else {
                    $info['permissoes'] = $this->user_group;
                    redirect('escala/razao/list/erro', 'refresh');
                }
            
                break;
            default:
                redirect('escala/razao/list', 'refresh');
                break;
        }
    }

    /**@
    Controller das trocas
    Recebe duas variaveis, $action e $id.
    @return void
    **/
    public function troca($action = '', $id = '')
    {
        switch ($action) {
            case 'nova':
                $info = $this->input->post(null, true);
                
                $info['id'] = $this->escala_model->adicionar_troca($info);
                redirect('escala/view/'.$info['escala_id'], 'refresh');
            
                break;
            case 'update':
                
                $this->form_validation->set_rules('razao', 'Razão', 'trim|required');
                
                if ($this->form_validation->run() == true) {

                    $info = $this->input->post(null, true);
                    $info['id'] = $this->escala_model->atualizar_razao($info);
                    
                    redirect('escala/razao/list', 'refresh');
                } else {
                    $info['permissoes'] = $this->user_group;
                    redirect('escala/razao/list/erro', 'refresh');
                }
            
                break;
            default:
                redirect('escala/razao/list', 'refresh');
                break;
        }
    }

    /**@
    Controller das previsoes.
    @return void
    **/
    public function previsao($id = '')
    {
        //$id da escala
        $info = array();
        $info['id'] = $id;
        $escala = $this->escala_model->ler($info);
        if(empty($escala)){
            redirect('escala/list', 'refresh');
        }
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
                $nims[$nim['militar_nim']] = $nim['militar_nim'];
                unset($nims[$cont]);
                $cont++;
                
            }
            $info['nims'] = $nims;
            $info['escala_id'] = $id;
            //militares desta escala
            $info['militares'] = $this->militar_model->ler($info);
        }
        else 
        {
            $info['militares'] = array();
            unset($info['id']);
        }
        if ($info['escala']['diario'])
        {
            //ordena dos militares por folga. Os que teem gdh_ultimo null, aparecem antes do mais folgado
            usort($info['militares'], array($this, '_compara_data'));
            //lista de dispensas dos militares que estao na escala.
            $dispensas = $this->escala_model->ler_dispensa($info);
            
            //vejo o nr de militares a nomear, e mostro o n ultimos.
            //a partir dai, mostro por folga, até 1 mês para a frente.
            $nr_a_nomear = $info['escala']['numero_nomeados'];
            $ultimos_nomeados = array_slice($info['militares'], -$nr_a_nomear);
            $data_ultimo_servico = $ultimos_nomeados[0]['gdh_ultimo'];
            $data_temp = date('Y-m-d', strtotime($data_ultimo_servico));
            $data_final_previsao = date('Y-m-d', strtotime('+1 month', strtotime($data_ultimo_servico)));
            $hoje = date('Y-m-d', strtotime('today'));
            
            //lista de feriados
            $feriados = $this->escala_model->ler_feriado($info);
            
            //aqui fora tenho que garantir que a lista de militares está ordenada??
            //crio uma variavel militares, para nao mexer na lista direitinha da info.
            $militares = $info['militares'];

            for($data_final_previsao; $data_temp  < $data_final_previsao;
                $data_temp = date('Y-m-d', strtotime('+1 day', strtotime($data_temp))))
            {
                //este teste é para ver se é escala A ou B, e se o dia pertence a uma ou outra.
                if ($info['escala']['semana'] == !$this->_fim_de_semana($data_temp, $feriados)){
                    
                    usort($militares, array($this, '_compara_data'));
                    //crio um array com os dias e preencho com a lista de:
                    //militar nomeavel, array dos militares dispensados+razao, e o reserva.
                    
                    $resultado = $this->_separa_dispensados($data_temp, $militares, $dispensas);
                    $nomeaveis = $resultado['nomeaveis'];
                    $razoes[$data_temp] = $resultado['razoes'];
                    
                    //echo('resultado '.$data_temp);
                    
                    $previsao[$data_temp] = array_slice($nomeaveis, 0, $nr_a_nomear);
                    $reserva[$data_temp] = array_slice($nomeaveis, 1, $nr_a_nomear);
                    $indisponiveis[$data_temp] = $resultado['dispensados'];
                    
                    for($cont = $nr_a_nomear-1; $cont >= 0; $cont--)
                    {
                        $nim = $previsao[$data_temp][$cont]['nim'];
                        $key = array_search($nim, array_column($militares, 'nim'));
                        $militares[$key]['gdh_ultimo'] = $data_temp;
                        //var_dump($nr_a_nomear);
                        //var_dump($key);
                    }
                    //echo('previsao');
                    //var_dump($previsao);
                    //var_dump($militares);
                    //var_dump($reservisto);
                }
            }
            $info['razoes'] = $razoes;
            $info['previsto'] = $previsao;
            $info['reserva'] = $reserva;
            $info['indisponiveis'] = $indisponiveis;
            
            //var_dump($info);
            //var_dump($ultimos_nomeados);
            //var_dump($data_ultimo_servico);
            //var_dump($data_temp);
            //var_dump($data_final_previsao);
            //var_dump($dispensas);
            //var_dump($razoes);
            //var_dump($previsao);
            //var_dump($reserva);
            //var_dump($indisponiveis);

            //estudar a relacao entre as razoes e as escalas. Que razoes dispensam de que escalas??
            //grau de precedencia entre escalas!!! Posso impor isso nas nomeações?? Se nomeado, aparece sombreado??
            
            //escalas novas, os militares teem que ter todos uma folga igual.
            //Esta folga é necessária para calcular a partir dela 30 dias.
            unset($info['nims']);
        }
        //var_dump($info['razoes']);
        //var_dump($info['indisponiveis']);
        //var_dump($info['previsto']);
        //var_dump($info['reserva']);
        $info['permissoes'] = $this->user_group;
        $this->template->load('template', 'escala/previsao', $info);
    }

    /**@
    Atualizar o estado de nomeado
    @return void
    **/
    public function Nomear()
    {
        //$permissoes = $this->user_group;
        //if (!$permissoes['secpess']) {
        //    redirect('medalha', 'refresh');
        //}
        $info = array();
        $post = $this->input->post(null, true);
        
        $info['militar_nim'] = $post['militar_nim'];
        $info['escala_id'] = $post['escala_id'];
        
        $info['nomeado'] = $post['nomeado'] ? '0' : '1';
        $info['resultado'] = $this->escala_model->nomear_militar_escala($info);
        
        redirect('escala/previsao/'.$info['escala_id'], 'refresh');
    }
    
}

/* End of file escala.php */
/* Location: ./application/controllers/escala.php */