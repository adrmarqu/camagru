<?php

require_once BACKEND . 'controller/BaseController.php';
require_once BACKEND . 'model/code/CodeModel.php';

class CodeController extends BaseController
{
    private function newCode(): void
    {
        $another = new CodeModel();
        $result = $another->setVerificationCode($_SESSION['user']['id'], $_SESSION['user']['email']);

        $this->reload($this->name, $result['message']);
    }

    public function account(): void
    {
        $this->name = 'verification';
        $error = $this->getFlash($this->name);

        if ($this->isPost())
        {
            if (isset($_POST['action']) && $_POST['action'] === 'generate')
                $this->newCode();

            $ver = $_POST['verification'];

            $validation = new FormValidation();
            $res = $validation->verification($ver);

            if ($res['success'] === false)
                $this->reload($this->name, $res['message']);

            $id = $_SESSION['user']['id'];

            $model = new TokenModel();
            $result = $model->account($id, $ver);
            
            if ($result['success'] === false)
                $this->reload($this->name, $result['message']);

            $model->updateUserVerification($id);
            $model->deleteCode($id);
            
            $this->redirect('login');
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Verification',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => $this->name,
            'form_output' => $error,
            'btn_del' => t('form.del'),
            'btn_send' => t('form.send'),
            'verification' => t('form.verification'),
            'send_code' => t('form.send_code')
        ],
        [
            'formContent' => 'form/verification'
        ]);
    }

    public function email(): void
    {
        if (!isset($_GET['token']))
            $this->reload('token_email', t('errors.token'), 'update-email');

        $model = new TokenModel();
        $result = $model->email();

        if (!$result['success'])
            $this->reload('token_email', $result['message'], 'update-email');
        $this->redirect('home');
    }
}