<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Tomchochola\Laratchi\Auth\Http\Resources\MeJsonApiResource as LaratchiMeJsonApiResource;

/**
 * @property User $resource
 */
class MeJsonApiResource extends LaratchiMeJsonApiResource
{
    /**
     * @inheritDoc
     */
    public function __construct(User $resource)
    {
        parent::__construct($resource);
    }

    /**
     * @inheritDoc
     */
    public function getAttributes(): array
    {
        return \array_merge(parent::getAttributes(), [
            'email' => $this->resource->getEmail(),
            'name' => $this->resource->getName(),
            'locale' => $this->resource->getLocale(),
            'email_verified_at' => $this->resource->getEmailVerifiedAt(),
        ]);
    }
}
