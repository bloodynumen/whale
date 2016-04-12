<?php
class Img extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('hiphoto', null, 'Hiphoto');
    }

    public function index()
    {
    }

    public function upload()
    {
        $tmpName = $_FILES['upload_img']['tmp_name'];
        $imgSize = $_FILES['upload_img']['size'];
        if ($imgSize > (300 * 1024)) {
            return array(
                'result' => 0,
                'msg' => '图片大于300K 请优化图片',
            );
        }
        $picInfo = $this->Hiphoto->upload($tmpName);
        switch ($picInfo['error']) {
            case 1:
                return array(
                    'result' => 0,
                    'msg' => 'failed copy',
                );
                break;
            case 2:
                return array(
                    'result' => 0,
                    'msg' => 'failed upload',
                );
                break;
            default:
                return array(
                    'result' => 1,
                    'msg' => 'success',
                    'picInfo' => $picInfo,
                );
                break;
        }
    }
}
