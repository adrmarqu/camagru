<?php

require_once BACKEND . 'base/BaseController.php';

class SettingsController extends BaseController
{
    public function settings()
    {
        $this->render('settings.tpl', [], []);
    }
}