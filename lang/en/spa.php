<?php

declare(strict_types=1);

return [
    'password_init_url' => mustConfigString('app.spa_url.en').'/password-init',
    'password_reset_url' => mustConfigString('app.spa_url.en').'/password-reset',
    'email_verification_verify_url' => mustConfigString('app.spa_url.en').'/email-verification',
];
