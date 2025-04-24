<?php

namespace App\Controller;
class HomeController
{
    public function presentation1()
    {
        $content= '';
        require 'App/View/home.php';
    }

}