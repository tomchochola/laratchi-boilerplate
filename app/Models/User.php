<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Support\Carbon;
use Tomchochola\Laratchi\Auth\User as LaratchiUser;
use Tomchochola\Laratchi\Http\JsonApi\JsonApiResource;
use Tomchochola\Laratchi\Http\JsonApi\ModelResource;

class User extends LaratchiUser implements MustVerifyEmailContract
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
     * E-mail getter.
     */
    public function getEmail(): string
    {
        return $this->mustString('email');
    }

    /**
     * Name getter.
     */
    public function getName(): string
    {
        return $this->mustString('name');
    }

    /**
     * Locale getter.
     */
    public function getLocale(): string
    {
        return $this->mustString('locale');
    }

    /**
     * E-mail verified at getter.
     */
    public function getEmailVerifiedAt(): ?Carbon
    {
        return $this->carbon('email_verified_at');
    }

    /**
     * @inheritDoc
     */
    public function meResource(): JsonApiResource
    {
        return new ModelResource($this, static function (self $me): array {
            return [
                'email' => $me->getEmail(),
                'name' => $me->getName(),
                'locale' => $me->getLocale(),
                'email_verified_at' => $me->getEmailVerifiedAt(),
                'created_at' => $me->getCreatedAt(),
                'updated_at' => $me->getUpdatedAt(),
            ];
        });
    }
}
