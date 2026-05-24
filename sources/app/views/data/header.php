<?php

$logged = isset($_SESSION['user']['id']);
$username = $_SESSION['user']['name'] ?? t('header.guest');
$class = "link header drop";
$mobClass = $class . " nav-mobile";

return 
[
    'a_href' => $logged ? 'gallery' : 'login',
    'a_text' => $logged ? t('gallery') : t('login'),

    'b_href' => $logged ? 'photo-editor' : 'signin',
    'b_text' => $logged ? t('photo-editor') : t('signin'),

    'nav_mobile' => $logged ? '' : 'nav-mobile',
    'btn_drop_type' => $logged ? 'btn btn-drop' : 'burguer',
    'btn_drop_content' => $logged ? $username : '<span></span><span></span><span></span>',

    'language_name' => n(),

    'lang_es' => t('lang.es'),
    'lang_ca' => t('lang.ca'),
    'lang_en' => t('lang.en'),

    'drop_links' =>
    [
        'file' => COMPONENTS . '/a.tpl',
        'data' => $logged ?
        [
            [
                'a_href' => 'gallery',
                'a_class' => $mobClass,
                'a_text' => t('gallery'),
            ],
            [
                'a_href' => 'photo-editor',
                'a_class' => $mobClass,
                'a_text' => t('photo-editor'),
            ],
            [
                'a_href' => 'user/gallery',
                'a_class' => $class,
                'a_text' => t('my_gallery'),
            ],
            [
                'a_href' => 'user/favorites',
                'a_class' => $class,
                'a_text' => t('favorites'),
            ],
            [
                'a_href' => 'user/settings',
                'a_class' => $class,
                'a_text' => t('settings'),
            ],
        ]
        :
        [
            [
                'a_href' => 'login',
                'a_class' => $class,
                'a_text' => t('login'),
            ],
            [
                'a_href' => 'signin',
                'a_class' => $class,
                'a_text' => t('signin'),
            ]
        ]
    ]
];