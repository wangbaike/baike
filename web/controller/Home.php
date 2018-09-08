<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace baike\controller;

use baike\framework\tools\View;
use baike\model\Fun;

/**
 * Description of Home
 *
 * @author Administrator
 */
class Home extends Topcontroller
{

    public function index()
    {
        //调用数据库->渲染模板

        /**
         * 第一种【对象调用方式】
         * $funModel = new Fun();
         * $list = $funModel->dbSelectAllRow();
         * 
         * 
         * 第一种【静态方法调用方式】
         * $list = Fun::instance()->dbSelectAllRow();
         */
        View::load('home');
    }

}
