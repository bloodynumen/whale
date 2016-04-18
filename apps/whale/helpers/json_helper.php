<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
    * @file json_helper.php
    * @brief 
    * @author sunhuai(v_sunhuai@baidu.com)
    * @version 
    * @date 2014/8/12 16:40:10
 */

if ( ! function_exists('output_json')) {
    /**
     * @brief 将数组转化为json格式,并输出json or jsonp
     */

    function output_json($arr) {
        $CI = &get_instance();
        header('Content-type: application/json');
        $callback = trim($CI->input->get('callback'));
        if (!$callback){
            echo json_encode($arr);
            return;
        }
        //安全过滤
        $hasUnSafeChar = preg_match('/[^a-zA-Z0-9_]+/', $callback);
        if ($hasUnSafeChar) {
            $callback = 'callback';
        }
        //增加js注释 防止低版本flash漏洞(可将返回值开头为CWS的字符串,当作代码执行,从而进行跨域操作,获取隐私数据)
        echo '/**/' . $callback . "(" . json_encode($arr) . ")";
    }

}
