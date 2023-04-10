<?php

declare(strict_types=1);

$url = mustConfigString('spa.url.cs');

return [
    'url' => $url,
    'password_init_url' => "{$url}/nastaveni-hesla",
    'password_reset_url' => "{$url}/obnoveni-hesla",
    'email_verification_url' => "{$url}/overeni-emailu",
];
