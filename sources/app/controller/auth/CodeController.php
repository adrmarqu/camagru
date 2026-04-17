<?php

require_once BACKEND . 'controller/BaseController.php';
require_once BACKEND . 'model/code/CodeModel.php';

class CodeController extends BaseController
{
    private function newCode(): string
    {
        $another = new CodeModel();
        $result = $another->setVerificationCode($_SESSION['user']['id']);
        return $result['message'];
    }

    public function verification(): void
    {
        $error = '';

        if (isset($_POST['action']) && $_POST['action'] === 'generate')
            $error = $this->newCode();
        else if ($this->isPost())
        {
            $ver = $_POST['verification'];

            $validation = new FormValidation();
            $res = $validation->verification($ver);

            if ($res['success'])
            {
                $id = $_SESSION['user']['id'];

                $model = new CodeModel();
                $result = $model->verification($id, $ver);

                if ($result['success'])
                {
                    $model->updateUserVerification($id);
                    $model->deleteCode($id);
                    $this->redirect('login');
                }
                else
                    $error = $result['message'];
            }
            else
                $error = $res['message'];
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Verification',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => 'verification',
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