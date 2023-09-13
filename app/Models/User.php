<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Tomchochola\Laratchi\Auth\User as LaratchiUser;
use Tomchochola\Laratchi\Http\JsonApi\JsonApiResource;
use Tomchochola\Laratchi\Http\JsonApi\ModelResource;

class User extends LaratchiUser
{
    /**
     * @inheritDoc
     *
     * @var array<mixed>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Modify embed query.
     */
    public static function queryEmbed(Builder $builder): void
    {
        $builder->getQuery()->select($builder->qualifyColumn('*'));
    }

    /**
     * E-mail getter.
     */
    public function getEmail(): string
    {
        return $this->assertString('email');
    }

    /**
     * Name getter.
     */
    public function getName(): string
    {
        return $this->assertString('name');
    }

    /**
     * Locale getter.
     */
    public function getLocale(): string
    {
        return $this->assertString('locale');
    }

    /**
     * E-mail verified at getter.
     */
    public function getEmailVerifiedAt(): Carbon|null
    {
        return $this->assertNullableCarbon('email_verified_at');
    }

    /**
     * @inheritDoc
     */
    public function meResource(): JsonApiResource
    {
        return new ModelResource(
            $this,
            static fn(self $resource): array => [
                'email' => $resource->getEmail(),
                'name' => $resource->getName(),
                'locale' => $resource->getLocale(),
                'email_verified_at' => $resource->getEmailVerifiedAt(),
                'created_at' => $resource->getCreatedAt(),
                'updated_at' => $resource->getUpdatedAt(),
            ],
        );
    }

    /**
     * Embed resource.
     */
    public function embedResource(): JsonApiResource
    {
        return new ModelResource(
            $this,
            static fn(self $resource): array => [
                'email' => $resource->getEmail(),
                'name' => $resource->getName(),
            ],
        );
    }
}
