<?php

declare(strict_types=1);

return [
    'password_init_url' => mustConfigString('app.spa_url.cs').'/nastaveni-hesla',
    'password_reset_url' => mustConfigString('app.spa_url.cs').'/obnoveni-hesla',
    'email_verification_verify_url' => mustConfigString('app.spa_url.cs').'/overeni-emailu',
];
