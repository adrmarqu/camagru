<?php

require_once BACKEND . 'base/BaseController.php';

class EditorController extends BaseController
{
    public function editor()
    {
        $this->render('editor.tpl', [],
        [
            'scripts' =>
            [
                'path' => COMPONENTS . 'script.tpl',
                'n' => 1,
                'data' => [['filename' => 'webcam.js?v=1']]
            ],
        ]);
    }

    public function uploadImg()
    {
        const $uploadDir = BACKEND . 'media/uploads/';

        if (!is_dir($uploadDir))
            mkdir($uploadDir, 0777, true);

        $nombreArchivo = basename($_FILES["imagen"]["name"]);
        $rutaFinal = $uploadDir . $nombreArchivo;

        move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaFinal);
    }
}