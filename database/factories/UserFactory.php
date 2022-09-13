<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
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
}
