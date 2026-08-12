<?php

class ResetController extends BaseController
{

    public function init(array $data): void
    {
    }

    public function validate(): void
    {
        $errors = [];
        $void = Lang::t('form.void');
    }

    public function execute(): void
    {
    }

    public function __invoke()
    {
        $data =
        [
            'css' => [ '/form.css' ],
            'scripts' => [ '/form.js' ]
        ];

        $this->render('/auth/', $data);
    }
}