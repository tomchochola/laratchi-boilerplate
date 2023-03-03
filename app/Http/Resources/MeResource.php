<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Tomchochola\Laratchi\Auth\Http\Resources\MeJsonApiResource as LaratchiMeJsonApiResource;

/**
 * @property User $resource
 */
class MeResource extends LaratchiMeJsonApiResource
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
        return [
            'email' => $this->resource->getEmail(),
            'name' => $this->resource->getName(),
            'locale' => $this->resource->getLocale(),
            'email_verified_at' => $this->resource->getEmailVerifiedAt(),
            'created_at' => $this->resource->getCreatedAt(),
            'updated_at' => $this->resource->getUpdatedAt(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getRelationships(): array
    {
        return [];
    }
}
