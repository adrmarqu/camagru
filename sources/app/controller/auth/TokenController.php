<?php

require_once BACKEND . 'base/BaseController.php';

class TokenController extends BaseController
{
    public function generateTokenAccount()
    {
        $this->render('form.tpl', [], []);
    }

    public function checkTokenAccount()
    {
        $this->render('form.tpl', [], []);
    }

    public function checkTokenEmail()
    {
        $this->load('gallery');
    }
}