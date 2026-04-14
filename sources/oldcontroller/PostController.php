<?php

require_once ROOT . 'validation/FormValidation.php';
require_once ROOT . 'model/UserModel.php';

class PostController
{
    private FormValidation  $form;

    public function __construct(array $post)
    {
        $this->form = new FormVadilation($post);
    }

    public function check(string $name)
    {
        $map =
        [
            'login' => fn() => $this->validate([],
            [
                '' => fn() => UserModel::userMatch($this->form->getLogin()),
                '' => fn() => UserModel::passMatch($this->form->getPass()),
            ]),

            'signin' => fn() => $this->validate(
            [
                'user' => fn() => $this->form->checkUser(),
                'email' => fn() => $this->form->checkEmail(),
                'pass' => fn() => $this->form->checkPass(),
                'passRep' => fn() => $this->form->checkPassRep(),
                'terms' => fn() => $this->form->checkTerms(),
            ],
            [
                '' => fn() => UserModel::userExists($this->form->getUser()),
                '' => fn() => UserModel::emailExists($this->form->getEmail())
            ]),
            
            'update-user' => fn() => $this->validate(
            [
                'user' => fn() => $this->form->checkUser(),
            ],
            [
                '' => fn() => UserModel::userExists($this->form->getUser()),
                '' => fn() => UserModel::updateUser($this->form->getUser())
            ]),
            
            'update-email' => fn() => $this->validate(
            [
                'email' => fn() => $this->form->checkEmail(),
            ],
            [
                '' => fn() => UserModel::emailExists($this->form->getEmail()),
                '' => fn() => UserModel::updateEmail($this->form->getEmail())
            ]),
            
            'update-pass' => fn() => $this->validate(
            [
                'pass' => fn() => $this->form->checkPass(),
                'passRep' => fn() => $this->form->checkPassRep(),
            ],
            [
                '' => fn() => UserModel::updatePass($this->form->getPass())
            ])
        ];

        if (!isset($map[$name]))
        {
            return 
            [
                'success' => false,
                'message' => t('errors.form.format')
            ];
        }

        $success = $map[$name]();

        return
        [
            'success' => $success,
            'message' => $this->error ?? '';
        ];
    }

    private function validate(array $data, array $bbdd): bool
    {
        foreach ($data as $field => $callback)
        {
            if (!$callback())
            {
                $this->error = t("errors.form.$field");
                return false;
            }
        }
        foreach ($bbdd as $field => $callback)
        {
            if (!$callback())
            {
                $this->error = t("errors.bbdd.$field");
                return false;
            }
        }
        return true;
    }
}