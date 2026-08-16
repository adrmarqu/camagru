<?php

class ProfileController extends BaseController
{
    private string $pass;
    private string $new;
    private string $conf;

    public function init(array $data): void
    {
        $this->pass = $data['password'] ?? '';
        $this->new = $data['new'] ?? '';
        $this->conf = $data['confirm'] ?? '';
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

        $this->render('/user/profile', $data);
    }
}