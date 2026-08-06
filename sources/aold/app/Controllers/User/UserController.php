<?php

abstract class UserController extends BaseController
{
    public function run()
    {
        $this->render("/user/profile", UserSources::profile());
    }
}