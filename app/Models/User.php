<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Tomchochola\Laratchi\Auth\User as LaratchiUser;

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
     * Modify index query.
     */
    public static function queryIndex(Builder $builder): void
    {
        $builder->with([])->getQuery()->select($builder->qualifyColumns(['id']));
    }

    /**
     * Modify detail query.
     */
    public static function queryDetail(Builder $builder): void
    {
        $builder->with([])->getQuery()->select($builder->qualifyColumns(['id']));
    }

    /**
     * Modify me query.
     */
    public static function queryMe(Builder $builder): void
    {
        $builder->with([])->getQuery()->select($builder->qualifyColumns(['*']));
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
