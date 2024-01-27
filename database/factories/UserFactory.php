<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Arr;
use Tomchochola\Laratchi\Auth\UserFactory as LaratchiUserFactory;

/**
 * @extends LaratchiUserFactory<User>
 */
class UserFactory extends LaratchiUserFactory
{
    /**
     * @inheritDoc
     */
    protected $model = User::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return \array_replace(Arr::except(parent::definition(), ['email_verified_at', 'remember_token', 'name']), []);
    }
}
