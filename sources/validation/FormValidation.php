<?php

class FormValidation
{
    private string $myPass;

    private array $rules =
    [
        'login' =>
        [
            'user' =>
            [
                ['required', 'errors.form.empty.usermail'],
                ['callback', 'checkUsermail', 'errors.bbdd.usermail']
            ],
            'pass' =>
            [
                ['required', 'errors.form.empty.pass'],
                ['callback', 'checkPass', 'errors.bbdd.pass']
            ],
        ],

        'signin' =>
        [
            'user' =>
            [
                ['required', 'errors.form.empty.user'],
                ['callback', 'checkUser', 'errors.form.user']
            ],
            'email' =>
            [
                ['required', 'errors.form.empty.email'],
                ['callback', 'checkEmail', 'errors.form.email']
            ],
            'pass' =>
            [
                ['required', 'errors.form.empty.pass'],
                ['callback', 'checkPass', 'errors.form.pass']
            ],
            'passRep' =>
            [
                ['required', 'errors.form.empty.rep_pass'],
                ['callback', 'checkPassRep', 'errors.form.rep_pass']
            ],
            'terms' =>
            [
                ['required', 'errors.form.terms']
            ]
        ],

        'update-user' =>
        [
            'user' =>
            [
                ['required', 'errors.form.empty.user'],
                ['callback', 'checkUser', 'errors.form.user']
            ],
            'currPass' =>
            [
                ['required', 'errors.form.empty.curr_pass'],
                ['callback', 'checkPass', 'errors.bbdd.curr_pass']
            ]
        ],

        'update-email' =>
        [
            'email' =>
            [
                ['required', 'errors.form.empty.email'],
                ['callback', 'checkEmail', 'errors.form.email']
            ],
            'currPass' =>
            [
                ['required', 'errors.form.empty.curr_pass'],
                ['callback', 'checkPass', 'errors.bbdd.curr_pass']
            ]
        ],

        'update-password' =>
        [
            'currPass' =>
            [
                ['required', 'errors.form.empty.curr_pass'],
                ['callback', 'checkPass', 'errors.bbdd.curr_pass']
            ],
            'pass' =>
            [
                ['required', 'errors.form.empty.new_pass'],
                ['callback', 'checkPass', 'errors.form.new_pass']
            ],
            'passRep' =>
            [
                ['required', 'errors.form.empty.rep_pass'],
                ['callback', 'checkPassRep', 'errors.form.rep_pass']
            ]
        ]
    ];

    public function checkForm(string $name, array $post): array
    {
        $msg = '';
        $success = false;

        if (!isset($this->rules[$name]))
            return ['success' => false, 'message' => t('errors.form.format')];

        foreach ($this->rules[$name] as $field => $rules)
        {
            if ($field === 'terms')
            {
                if (!isset($post['terms']))
                    return ['success' => false, 'message' => t('errors.form.terms')];
                continue;
            }

            $value = $post[$field] ?? null;

            foreach ($rules as $rule)
            {
                if ($rule[0] === 'required' && empty($value))
                    return ['success' => false, 'message' => t($rule[1])];

                if ($rule[0] === 'callback')
                {
                    $method = $rule[1];
                    if (!$this->$method($value))
                        return ['success' => false, 'message' => t($rule[2])];
                }
            }
        }
        return ['success' => true, 'message' => $msg];
    }

    private function checkUsermail(string $usermail): bool
    {
        if (str_contains($usermail, '@'))
            return $this->checkEmail($usermail);
        return $this->checkUser($usermail);
    }

    public function checkUser(string $user): bool
    {
        return preg_match('/^[a-zA-Z][a-zA-Z0-9_]{2,19}$/', $user);
    }

    public function checkEmail(string $email): bool
    {
        return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email);
    }

    public function checkPass(string $pass): bool
    {
        $this->myPass = $pass;
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,99}$/', $pass);
    }

    public function checkPassRep(string $rep): bool
    {
        return ($this->myPass ?? '') === $rep;

    }
}