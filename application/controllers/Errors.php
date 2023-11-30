<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Errors Controller
 *
 * @package Controllers
 */
class Errors extends EA_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('google_analytics');
        $this->load->model('settings_model');
    }

    /**
     * Display the 404 error page.
     */
    public function index()
    {
        $this->error404();
    }

    /**
     * Display the 404 error page.
     */
    public function error404()
    {
        $view['company_name'] = $this->settings_model->get_setting('company_name');

        $this->load->view('general/error404', $view);
    }
}
