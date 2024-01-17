<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use Illuminate\Support\Arr;

class RegisterRequest extends \Tomchochola\Laratchi\Auth\Http\Requests\RegisterRequest
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return \array_replace(Arr::except(parent::rules(), ['name']), []);
    }

    /**
     * @inheritDoc
     */
    public function data(): array
    {
        return \array_replace(Arr::except(parent::data(), ['email_verified_at', 'remember_token']), []);
    }
}
