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

    public function verification(): void
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

            $model = new CodeModel();
            $result = $model->verification($id, $ver);
            
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
            'formMsg' => $error,
            'btnDel' => t('form.del'),
            'btnSend' => t('form.send'),
            'verification' => t('form.verification'),
            'another' => t('form.another')
        ],
        [
            'formContent' => 'form/verification'
        ]);
    }
}