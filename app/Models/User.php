<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Tomchochola\Laratchi\Auth\User as LaratchiUser;

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
     * What is loaded on index.
     *
     * @return array<mixed>
     */
    public static function loadIndex(): array
    {
        return [];
    }

    /**
     * What is selected on index.
     *
     * @return array<mixed>
     */
    public static function selectIndex(): array
    {
        return ['users.id'];
    }

    /**
     * What is loaded on detail.
     *
     * @return array<mixed>
     */
    public static function loadDetail(): array
    {
        return [];
    }

    /**
     * What is selected on detail.
     *
     * @return array<mixed>
     */
    public static function selectDetail(): array
    {
        return ['users.id'];
    }

    /**
     * What is loaded on me.
     *
     * @return array<mixed>
     */
    public static function loadMe(): array
    {
        return [];
    }

    /**
     * What is selected on me.
     *
     * @return array<mixed>
     */
    public static function selectMe(): array
    {
        return ['users.*'];
    }

    /**
     * Modify index query.
     */
    public static function queryIndex(Builder $builder): void
    {
        $builder->with(static::loadIndex())->getQuery()->select(static::selectIndex());
    }

    /**
     * Modify detail query.
     */
    public static function queryDetail(Builder $builder): void
    {
        $builder->with(static::loadDetail())->getQuery()->select(static::selectDetail());
    }

    /**
     * Modify me query.
     */
    public static function queryMe(Builder $builder): void
    {
        $builder->with(static::loadMe())->getQuery()->select(static::selectMe());
    }

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
}
