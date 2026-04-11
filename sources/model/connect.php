<?php

$host = 'localhost';
$user = 'user';         
$pass = 'user';
$bd   = 'camagru';

$con = new mysqli($host, $user, $pass, $bd);

if ($con->connect_errno)
    die('Errorum de conexión (' . $con->connect_errno . ') ' . $con->connect_error);
/* else
    echo "Conexión establecida con la base de datos"; */