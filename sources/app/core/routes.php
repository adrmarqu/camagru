<?php

return
[
    // Auth
    'login' => [AuthController::class, 'login'],
    'signin' => [AuthController::class, 'signin'],

    // Verification
    'verification' => [CodeController::class, 'verification'],

    // Update user
    'update-user' => [UpdateController::class, 'user'],
    'update-email' => [UpdateController::class, 'email'],
    'update-password' => [UpdateController::class, 'password'],
];