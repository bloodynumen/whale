<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends WhaleController {
    public function index()
    {
        $this->load->helper('json');
        output_json(['a' => 1]);
        $this->template->display('welcome.tpl');
    }
}
