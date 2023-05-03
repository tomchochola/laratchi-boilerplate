<?php

declare(strict_types=1);

$url = mustConfigString('spa.url.en');

return [
    'url' => $url,
    'password_init_url' => "{$url}/password-init",
    'password_reset_url' => "{$url}/password-reset",
    'email_verification_url' => "{$url}/email-verification",
    'email_confirmation_url' => "{$url}/email-verification",
];
