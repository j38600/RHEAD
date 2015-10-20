<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incident extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->lang->load('auth');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        } else {
            $this->template->set('title', 'Incidentes');
            $this->template->set('nav', 'incident');
            $this->template->set('user', $this->ion_auth->user()->row()->username);
            $this->template->set(
                'admin', ($this->ion_auth->is_admin())? true: false
            );
        }
        $this->output->enable_profiler(TRUE);
    }

    public function index()
    {
        $info = array();
        $info['incidentes'] = $this->incident_model->ler($info);
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'incident/list', $info);
    }

    public function map()
    {
        $info = array();
        $info['incidentes'] = $this->incident_model->ler($info);
        $info['admin'] = $this->ion_auth->is_admin();
        $this->template->load('template', 'incident/map', $info);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/incident.php */