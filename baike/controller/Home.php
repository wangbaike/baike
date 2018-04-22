<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace baike\controller;
use baike\tools\InputParam;

/**
 * Description of Home
 *
 * @author Administrator
 */
class Home
{

    public function index()
    {
        echo 'Hello word !';
        $pathInfo = InputParam::get();
        print_r($pathInfo);
    }

}
