<?php


/* Separar mejor el archivo: Decidir donde ir, validar form, bbdd, render */



require_once ROOT . 'views/View.php';

class AuthController
{
    private array   $incs = [];
    private array   $vars = [];
    private View    $view;

    public function __construct(string $file)
    {
        $this->view = new View($file);
    }

    private function checkForm(string $type): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            return '';
        
        $check = new CheckForm();
        $msg = $check->launch($type, $_POST);

        if ($msg === null)
        {
            header("Location: /index.php?page=login"); // no tengo home de momento
            exit();
        }
        
        return $msg;
    }

    public function login(array $lang)
    {
        $type = 'login';
        $msg = $this->checkForm($type);

        $this->incs = 
        [
            'formContent' => 'components/form/login.tpl'
        ];
        $this->vars =
        [
            'title' => 'Camagru | Login',
            'page' => $type,
            'type' => $type,
            
            'logUser' => $lang['usermail'] ?? '',
            'logPass' => $lang['pass'] ?? ''
        ];

        $this->launch($lang, $msg);
    }

    public function signin(array $lang)
    {
        $type = 'signin';
        $msg = $this->checkForm($type);

        $this->incs = 
        [
            'formContent' => 'components/form/signin.tpl'
        ];
        $this->vars =
        [
            'title' => 'Camagru | Signin',
            'page' => 'signin',
            'type' => 'signin',
            
            'signUser' => $lang['user'] ?? '',
            'signEmail' => $lang['email'] ?? '',
            'signPass' => $lang['pass'] ?? '',
            'signPassRep' => $lang['rep_pass'] ?? '',
            'signTerms' => $lang['term'] ?? ''
        ];

        $this->launch($lang, $msg);
    }

    public function update(array $lang, string $option)
    {
        switch ($option)
        {
            case 'user':
                $file = 'components/form/updateUser.tpl';
                $user = $lang['new_user'];
                $id = 'updateUser';
                break ;
            case 'email':
                $file = 'components/form/updateEmail.tpl';
                $email = $lang['new_email'];
                $id = 'updateEmail';
                break ;
            case 'pass':
                $file = 'components/form/updatePass.tpl';
                $newPass = $lang['new_pass'];
                $repPass = $lang['rep_pass'];
                $id = 'updatePass';
                break ;
            default:
                header("Location: /index.php?page=login"); // no tengo home de momento
                exit();
        }
        $msg = $this->checkForm($id);

        $this->incs = 
        [
            'formContent' => $file
        ];
        $this->vars =
        [
            'title' => 'Camagru | Update',
            'page' => ('update&upd_opt=' . $option) ?? '',
            'type' => $id ?? '',
            
            'newUser' => $user ?? '',
            'newEmail' => $email ?? '',
            'newCurrentPass' => $lang['curr_pass'] ?? '',
            'newNewPass' => $newPass ?? '',
            'newPassRep' => $repPass ?? ''
        ];

        $this->launch($lang, $msg);
    }

    private function launch(array $lang, string $msg)
    {
        /* Common variables */
        $baseVars =
        [
            'language' => $lang['lang'] ?? '',
            'btnDel' => $lang['del'] ?? '',
            'btnSend' => $lang['send'] ?? '',
            'formMsg' => $msg ?? '',
            'links' => $this->view->getHeadLinks(['form']),
            'scripts' => $this->view->getHeadScripts(['checkForm'])
        ];

        $this->view->addIncludes($this->incs);
        $this->view->addVariables($this->vars);
        $this->view->addVariables($baseVars);

        echo $this->view->getHtml();
        exit();
    }
}