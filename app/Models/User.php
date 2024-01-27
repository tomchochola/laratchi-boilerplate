<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
    protected $casts = [];

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
     * Locale getter.
     */
    public function getLocale(): string
    {
        return $this->assertString('locale');
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
                'locale' => $resource->getLocale(),
                'created_at' => $resource->getCreatedAt()->toJSON(),
                'updated_at' => $resource->getUpdatedAt()->toJSON(),
            ],
        );
    }

    /**
     * @inheritDoc
     */
    public function getRememberTokenName(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getRememberToken(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function setRememberToken(mixed $value): void {}

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail(): string
    {
        return $this->getEmail();
    }
}
