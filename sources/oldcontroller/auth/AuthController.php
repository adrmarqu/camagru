<?php

require_once ROOT . 'model/model.php';
require_once ROOT . 'validation/FormValidation.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['user']) && isset($_POST['pass']))
            {
                $usermail = $_POST['user'];
                $pass = $_POST['pass'];

                $model = new UserModel();
                $result = $model->Login($usermail, $pass);
                if ($result['success'])
                {
                    $_SESSION['user'] = 
                    [
                        'id' => $result['id'],
                        'username' => $result['username'],
                        'email' => $result['email']
                    ];
                    header('Location: /' . t('lang') . '/home', true, 301);
                    exit();
                }
                $error = $result['message'] ?? 'Error';
            }
            else
                $error = 'Unknown error';   
        }

        $data =
        [
            'language' => '',
            'title' => '',
            'links' => '',
            'scripts' => '',
            'page' => '',
            'formMsg' => $error ?? '',
            'btnDel' => '',
            'btnSend' => '',
            'logUser' => '',
            'logPass' => '',
        ];
        $incs =
        [
            'formContent' => ''
        ];

        $view = new View(ROOT . 'view/templates/components/form.tpl');
        $view->addVariables($data);
        $view->addIncludes($incs);
        echo $view->getHtml();
        exit();
    }

    public function signin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['user']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['passRep']) && isset($_POST['terms']))
            {
                $user = $_POST['user'];
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $passRep = $_POST['passRep'];
                $terms = $_POST['terms'];

                $validation = new FormValidation();

                $error = $validation->user($user);
                if (!$error)
                    $error = $validation->email($email);
                if (!$error)
                    $error = $validation->pass($pass);
                if (!$error)
                    $error = $validation->passRep($passRep);
                if (!$error)
                    $error = $validation->terms($terms);
                
                if (!$error)
                {
                    $model = new UserModel();
                    $result = $model->Signin($user, $email, $pass);
                    if ($result['success'])
                    {
                        $_SESSION['user'] = 
                        [
                            'id' => $result['id'],
                            'username' => $result['username'],
                            'email' => $result['email']
                        ];
                        header('Location: /' . t('lang') . '/home', true, 301);
                        exit();
                    }
                }
                $error = $result['message'] ?? 'Error';
            }
            else
                $error = 'Campos vacios en el form';   
        }

        $data =
        [
            'language' => '',
            'title' => '',
            'links' => '',
            'scripts' => '',
            'page' => '',
            'formMsg' => $error ?? '',
            'btnDel' => '',
            'btnSend' => '',
            'signUser' => '',
            'signPass' => '',
            'signPassRep' => '',
            'signEmail' => '',
            'signTerms' => '',
        ];
        $incs =
        [
            'formContent' => ''
        ];

        $view = new View(ROOT . 'view/templates/components/form.tpl');
        $view->addVariables($data);
        $view->addIncludes($incs);
        echo $view->getHtml();
        exit();
    }

    public function updateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['user']))
            {
                $user = $_POST['user'];

                $validation = new FormValidation();
                $error = $validation->user($user);

                if (!$error)
                {
                    $model = new UserModel();
                    $result = $model->update($user);
                    if ($result['success'])
                    {
                        $_SESSION['user']['username'] = $result['username'];
                        header('Location: /' . t('lang') . '/home', true, 301);
                        exit();
                    }
                }
                $error = $result['message'] ?? 'Error';
            }
            else
                $error = 'Campos vacios en el form';   
        }

        $data =
        [
            'language' => '',
            'title' => '',
            'links' => '',
            'scripts' => '',
            'page' => '',
            'formMsg' => $error ?? '',
            'btnDel' => '',
            'btnSend' => '',
            'newUser' => '',
            'newCurrentPass' => '',
        ];
        $incs =
        [
            'formContent' => ''
        ];

        $view = new View(ROOT . 'view/templates/components/form.tpl');
        $view->addVariables($data);
        $view->addIncludes($incs);
        echo $view->getHtml();
        exit();
    }

    public function updateEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['email']))
            {
                $email = $_POST['email'];

                $validation = new FormValidation();
                $error = $validation->email($email);

                if (!$error)
                {
                    $model = new UserModel();
                    $result = $model->update($email);
                    if ($result['success'])
                    {
                        $_SESSION['user']['email'] = $result['email'];
                        header('Location: /' . t('lang') . '/home', true, 301);
                        exit();
                    }
                }
                $error = $result['message'] ?? 'Error';
            }
            else
                $error = 'Campos vacios en el form';   
        }

        $data =
        [
            'language' => '',
            'title' => '',
            'links' => '',
            'scripts' => '',
            'page' => '',
            'formMsg' => $error ?? '',
            'btnDel' => '',
            'btnSend' => '',
            'newEmail' => '',
            'newCurrentPass' => '',
        ];
        $incs =
        [
            'formContent' => ''
        ];

        $view = new View(ROOT . 'view/templates/components/form.tpl');
        $view->addVariables($data);
        $view->addIncludes($incs);
        echo $view->getHtml();
        exit();
    }

    public function updatePass()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['newPass']))
            {
                $pass = $_POST['newPass'];
                $passRep = $_POST['passRep'];

                $validation = new FormValidation();
                $error = $validation->pass($pass);
                if (!$error)
                    $error = $validation->passRep($passRep);

                if (!$error)
                {
                    $model = new UserModel();
                    $result = $model->updatePass($pass);
                    if ($result['success'])
                    {
                        header('Location: /' . t('lang') . '/home', true, 301);
                        exit();
                    }
                }
                $error = $result['message'] ?? 'Error';
            }
            else
                $error = 'Campos vacios en el form';   
        }

        $data =
        [
            'language' => '',
            'title' => '',
            'links' => '',
            'scripts' => '',
            'page' => '',
            'formMsg' => $error ?? '',
            'btnDel' => '',
            'btnSend' => '',
            'newCurrentPass' => '',
            'newNewPass' => '',
            'newPassRep' => '',
        ];
        $incs =
        [
            'formContent' => ''
        ];

        $view = new View(ROOT . 'view/templates/components/form.tpl');
        $view->addVariables($data);
        $view->addIncludes($incs);
        echo $view->getHtml();
        exit();
    }
}