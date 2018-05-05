<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace baike\controller;

use baike\tools\View;
use baike\model\DataModel;

/**
 * Description of Home
 *
 * @author Administrator
 */
class Home
{

    public function index()
    {
        /**
         * 调用数据库
         * 渲染模板
         */
        //$list = DataModel::getInstance('fun')->dbSelectAllRow();
        // print_r($list);
        View::load('home');
    }

}
