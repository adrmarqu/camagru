<?php

$logged = isset($_SESSION['user']['id']);
$username = $_SESSION['user']['name'] ?? t('header.guest');
$class = "link header drop";
$mobClass = $class . " nav-mobile";

return 
[
    'a_href' => $logged ? 'gallery' : 'login',
    'a_text' => $logged ? t('heaer.gallery') : t('header.login'),

    'b_href' => $logged ? 'photo-editor' : 'signin',
    'b_text' => $logged ? t('header.photo-editor') : t('header.signin'),

    'nav_mobile' => $logged ? '' : 'nav-mobile',
    'btn_drop_type' => $logged ? 'btn btn-drop' : 'burguer',
    'btn_drop_content' => $logged ? $username : '<span></span><span></span><span></span>',

    'language_name' => n(),

    'lang_es' => t('lang.es'),
    'lang_ca' => t('lang.ca'),
    'lang_en' => t('lang.en'),

    'logout' => !$logged ? '' :
    [
        'file' => COMPONENTS . '/image.tpl',
        'data' => 
        [
            [
                'img_id' => '',   
                'img_class' => '',   
                'img_src' => ASSETS . 'logout.png',
                'img_alt' => 'logout image',
                'img_title' => 'logout',
            ]
        ]
    ],

    'drop_links' =>
    [
        'file' => COMPONENTS . '/a.tpl',
        'data' => $logged ?
        [
            [
                'a_href' => 'gallery',
                'a_class' => $mobClass,
                'a_text' => t('header.gallery'),
            ],
            [
                'a_href' => 'photo-editor',
                'a_class' => $mobClass,
                'a_text' => t('header.photo-editor'),
            ],
            [
                'a_href' => 'user/gallery',
                'a_class' => $class,
                'a_text' => t('header.my_gallery'),
            ],
            [
                'a_href' => 'user/favorites',
                'a_class' => $class,
                'a_text' => t('header.favorites'),
            ],
            [
                'a_href' => 'user/settings',
                'a_class' => $class,
                'a_text' => t('header.settings'),
            ],
        ]
        :
        [
            [
                'a_href' => 'login',
                'a_class' => $class,
                'a_text' => t('header.login'),
            ],
            [
                'a_href' => 'signin',
                'a_class' => $class,
                'a_text' => t('header.signin'),
            ]
        ]
    ]
];