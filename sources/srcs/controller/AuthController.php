<?php

require_once __DIR__ . '/../views/view.php';

const formDir = '/../views/tpls/components/form/';
const TPL_FORM = __DIR__ . formDir . 'form.tpl';
const TPL_LOG = __DIR__ . formDir . 'login.tpl';
const TPL_SIGN = __DIR__ . formDir . 'signin.tpl';
const TPL_UPDT = __DIR__ . formDir . 'update.tpl';

class AuthController
{
    private string  $user;
    private string  $pass;
    private string  $confirmPass;
    private string  $email;
    private bool    $terms;

    private string  $error;

    // Public

    public function login()
    {
        $this->createForm('login');
    }

    public function signin()
    {
        $this->createForm('signin');
    }

    // Private

    // Get data from post
   /*  private function getData($data)
    {

    } */

    private function getFormContent(string $type): string
    {
        $arr = 
        [
            'formUserEmail' => 'Usuario/Email',
            'formUser' => 'Usuario',
            'formPass' => 'Contraseña',
            'formPassRep' => 'Repetir contraseña',
            'formEmail' => 'Correo',
            'formTerms' => 'Aceptar terminos',
            'formCurrentPass' => 'Contraseña actual',
        ];

        switch ($type)
        {
            case 'login':
                $html = getHtml(TPL_LOG, $arr);
                break ;
            case 'signin':
                $html = getHtml(TPL_SIGN, $arr);
                break ;
            /*case 'update':
                $html = getHtml(TPL_UPD, $arr);
                break ; */
            default:
                echo "That page doesn't exists";
        }
        return $html ?? '';
    }

    // Create the form with the fusion of different .tpl
    private function createForm(string $type)
    {
        // Contenido formulario
        $formArr = 
        [
            'formPage' => $type,
            'formContent' => $this->getFormContent($type),
            'formType' => $type,
            'btnDel' => 'Borrar',
            'btnSend' => 'Enviar'
        ];

        $html = getHtml(TPL_FORM, $formArr);
        showTPL($type, $html);
    }
}