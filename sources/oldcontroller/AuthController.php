<?php

require_once ROOT . 'model/model.php';

class AuthController
{
    private string      $formMsg;

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['user']) && isset($_POST['pass']))
            {
                $usermail = $_POST['user'];
                $pass = $_POST['pass'];

                $model = new UserModel();
                $result = $model->getFeedbackLogin($usermail, $pass);
                if ($result['success'])
                {
                    $_SESSION['user'] = 
                    [
                        'id' => $result['id'],
                        'username' => $result['username'],
                        'email' => $result['email']
                    ];
                    header('Location: /' . t('lang') . '/login', true, 301);
                    exit();
                }
                $this->error = $result['message'] ?? 'Error';
            }
            else
                $this->formMsg = 'Unknown error';   
        }

        $data =
        [
            'language' => '',
            'title' => '',
            'links' => '',
            'scripts' => '',
            'page' => '',
            'formMsg' => '',
            'btnDel' => '',
            'btnSend' => '',
            'logUser' => '',
            'logPass' => '',
        ];
        $incs =
        [
            'formContent' => ''
        ]

        $view = new View(ROOT . 'view/templates/components/form.tpl');
        $view->addVariables($data);
        $view->addIncludes($incs);
        echo $this->view->getHtml();
        exit();
    }

    public function signin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if (isset($_POST['user']) && isset($_POST['pass']))
            {
                $usermail = $_POST['user'];
                $pass = $_POST['pass'];

                $model = new UserModel();
                $result = $model->getFeedbackLogin($usermail, $pass);
                if ($result['success'])
                {
                    $_SESSION['user'] = 
                    [
                        'id' => $result['id'],
                        'username' => $result['username'],
                        'email' => $result['email']
                    ];
                    header('Location: /' . t('lang') . '/login', true, 301);
                    exit();
                }
                $this->error = $result['message'] ?? 'Error';
            }
            else
                $this->formMsg = 'Unknown error';   
        }

        $data =
        [
            'language' => '',
            'title' => '',
            'links' => '',
            'scripts' => '',
            'page' => '',
            'formMsg' => '',
            'btnDel' => '',
            'btnSend' => '',
            'logUser' => '',
            'logPass' => '',
        ];
        $incs =
        [
            'formContent' => ''
        ]

        $view = new View(ROOT . 'view/templates/components/form.tpl');
        $view->addVariables($data);
        $view->addIncludes($incs);
        echo $this->view->getHtml();
        exit();
    }
}