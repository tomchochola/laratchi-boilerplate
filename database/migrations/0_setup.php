<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Tomchochola\Laratchi\Support\Resolver;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Resolver::resolveSchemaBuilder()->create('users', static function (Blueprint $table): void {
            $table->id();

            $table->string('email')->unique();

            $table->string('password')->nullable();

            $table->char('locale', 2);

            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }
};
