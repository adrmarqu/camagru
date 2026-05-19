<?php

$conn = isset($_SESSION['user']['id']);

return 
[
    'gallery' => t(''),
    'editor' => t(''),
    'my_gallery' => t(''),
    'favorite' => t(''),
    'settings' => t(''),
    '' => t(''),
    '' => t(''),
    
    'logout' => t(''),
    'username' => $_SESSION['user']['name'] ?? t('header.invited'),

    'login' => t(''),
    'signin' => t(''),

    'conn_class' => $conn ? '' : 'hidden',
    'discon_class' => $conn ? 'hidden' : ''
];