<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends WhaleController {
    public function index()
    {
        $this->template->display('welcome.tpl');
    }
}
