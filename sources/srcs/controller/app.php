<?php

require_once __DIR__ . '/../views/view.php';

$val = $_GET['val'] ?? 0;

if ($val == 1)
    viewGallery();
if ($val == 2)
    viewLogin();
if ($val == 3)
    viewVerfify();
if ($val == 4)
    viewEditor();
else
    viewGallery();