<?php

return
[
    // Auth
    'login' => [AuthController::class, 'login'],
    'signin' => [AuthController::class, 'signin'],

    // Update user
    'update-user' => [UserController::class, 'user'],
    'update-email' => [UserController::class, 'email'],
    'update-password' => [UserController::class, 'password'],
];