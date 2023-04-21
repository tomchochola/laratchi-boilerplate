<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (isEnv(['staging', 'production'])) {
            return;
        }

        if (User::query()->getQuery()->exists()) {
            return;
        }

        UserFactory::new()->locale(resolveApp()->getLocale())->password()->blankRememberToken()->unverified()->createOne(['email' => 'testovaci@uzivatel.cz', 'name' => 'Testovací Uživatel']);
    }
}
