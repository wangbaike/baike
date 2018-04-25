<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace baike\controller;

use baike\tools\InputParam;
use baike\tools\View;

/**
 * Description of Home
 *
 * @author Administrator
 */
class Home
{

    public function index()
    {
        View::load('home');
    }

}
