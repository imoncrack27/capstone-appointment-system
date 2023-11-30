<?php defined('BASEPATH') or exit('No direct script access allowed');



/**
 * Captcha Controller
 *
 * @package Controllers
 */
class Captcha extends EA_Controller {
    /**
     * Class Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library('captcha_builder');
    }

    /**
     * Make a request to this method to get a captcha image.
     */
    public function index()
    {
        header('Content-type: image/jpeg');
        $this->captcha_builder->build();
        $this->session->set_userdata('captcha_phrase', $this->captcha_builder->getPhrase());
        $this->captcha_builder->output();
    }
}
