<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller
{

    public function index()
    {
        //migration->current looks for version in migration config file
        //migration->latest looks for latest version in filesystem
        if($this->migration->current() === FALSE)
        {
            show_error($this->migration->error_string());
        }else{
            echo('Migration sucessfull');
        }
    }
}
