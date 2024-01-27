<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use Illuminate\Support\Arr;

class MeUpdateRequest extends \Tomchochola\Laratchi\Auth\Http\Requests\MeUpdateRequest
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return \array_replace(Arr::except(parent::rules(), ['name']), []);
    }
}
