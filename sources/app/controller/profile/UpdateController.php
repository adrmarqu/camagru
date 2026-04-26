<?php

require_once BACKEND . 'base/BaseController.php';

class UpdateController extends BaseController
{
    public function user()
    {
        $this->render('form.tpl', [], []);
    }

    public function email()
    {
        $this->render('form.tpl', [], []);
    }

    public function password()
    {
        $this->render('form.tpl', [], []);
    }
}