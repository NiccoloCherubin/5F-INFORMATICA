<?php
namespace App\Controller;
class LoginController
{
    public function loginAction()
    {
        $content= '';
        require 'App/View/loginForm.php';
    }

}