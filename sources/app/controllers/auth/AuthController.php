<?php

require_once CONTROLLERS . '/BaseController.php';
require_once VALIDATIONS . '/Form.php';
//require_once MODELS . '/Auth.php';

class AuthController extends BaseController
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function login()
    {
        if ($this->isPost())
        {
            /* Get data */
            $data = $this->getPostData(['usermail', 'pass']);
            $data['remember'] = isset($_POST['remember']);

            /* Check data */
            $errors = Form::login($data);
            if (!empty($errors))
                $this->setFlash($errors);

            /* Data base */
            /* $response = Auth::login($data);
            if (!$response['ok'])
                $this->setFlash($response['message']); */

            /* Move to sendEmail */
            $this->redirect('verify/account');
        }

        View::render($this->name, $this->errors);
    }
}

