<?php

require_once BACKEND . 'base/BaseController.php';

class EditorController extends BaseController
{
    public function editor()
    {
        $this->render('/editor.tpl',
        [
            'cancel' => t('btn.cancel'),
            'photo' => t('btn.photo'),
            'upload' => t('btn.upload'),
            'reset' => t('btn.reset'),
            'delete' => t('btn.delete'),
            'scale' => t('scale'),
            'rotation' => t('rotation'),

            'title' => 'Camagru | Editor'
        ],
        [
            'links' => 
            [
                'path' => COMPONENTS . '/link.tpl',
                'n' => 1,
                'data' => [['filename' => 'webcam.css?v=1']]
            ],
            'scripts' =>
            [
                'path' => COMPONENTS . '/script.tpl',
                'n' => 1,
                'data' => [['filename' => 'editor/editor.js?v=1']]
            ],
            'images' =>
            [
                'path' => COMPONENTS . '/image.tpl',
                'n' => 5,
                'data' =>
                [
                    [
                        'img_id' => '',
                        'img_class' => '',
                        'img_src' => ASSETS . '/bright.png',
                        'img_alt' => 'Bright',
                        'img_title' => 'Bright'
                    ],
                    [
                        'img_id' => '',
                        'img_class' => '',
                        'img_src' => ASSETS . '/fire.png',
                        'img_alt' => 'Fire',
                        'img_title' => 'Fire'
                    ],
                    [
                        'img_id' => '',
                        'img_class' => '',
                        'img_src' => ASSETS . '/fog.png',
                        'img_alt' => 'Fog',
                        'img_title' => 'Fog'
                    ],
                    [
                        'img_id' => '',
                        'img_class' => '',
                        'img_src' => ASSETS . '/flowers.png',
                        'img_alt' => 'Flowers',
                        'img_title' => 'Flowers'
                    ],
                    [
                        'img_id' => '',
                        'img_class' => '',
                        'img_src' => ASSETS . '/glasses.png',
                        'img_alt' => 'Glasses',
                        'img_title' => 'Glasses'
                    ],
                ]
            ],
            'thumbnails' =>
            [
                'path' => COMPONENTS . '/image.tpl',
                'n' => 5,
                'data' =>
                [
                    [
                        'img_id' => '',
                        'img_class' => '',
                        'img_src' => UPLOADS . '/upload.png',
                        'img_alt' => 'Upload',
                        'img_title' => 'Upload'
                    ],
                    [
                        'img_id' => '',
                        'img_class' => '',
                        'img_src' => UPLOADS . '/upload.png',
                        'img_alt' => 'Upload',
                        'img_title' => 'Upload'
                    ],
                    [
                        'img_id' => '',
                        'img_class' => '',
                        'img_src' => UPLOADS . '/upload.png',
                        'img_alt' => 'Upload',
                        'img_title' => 'Upload'
                    ],
                    [
                        'img_id' => '',
                        'img_class' => '',
                        'img_src' => UPLOADS . '/upload.png',
                        'img_alt' => 'Upload',
                        'img_title' => 'Upload'
                    ],
                    [
                        'img_id' => '',
                        'img_class' => '',
                        'img_src' => UPLOADS . '/upload.png',
                        'img_alt' => 'Upload',
                        'img_title' => 'Upload'
                    ],
                ]
            ]
        ]);
    }

    /* public function uploadImg()
    {
        const $uploadDir = BACKEND . 'media/uploads/';

        if (!is_dir($uploadDir))
            mkdir($uploadDir, 0777, true);

        $nombreArchivo = basename($_FILES["imagen"]["name"]);
        $rutaFinal = $uploadDir . $nombreArchivo;

        move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaFinal);
    } */
}