<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Tomchochola\Laratchi\Config\Config;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Config::inject()->appEnvIs(['staging', 'production'])) {
            return;
        }

        if (User::query()->getQuery()->exists()) {
            return;
        }

        UserFactory::new()
            ->password()
            ->createOne(['email' => 'test@test.com']);

        UserFactory::new()->randomLocale()->password()->count(100)->create();
    }
}
