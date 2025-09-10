<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            if (!Schema::hasColumn('sellers', 'email')) {
                $table->string('email')->nullable()->unique();
            }
            if (!Schema::hasColumn('sellers', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable();
            }
            if (!Schema::hasColumn('sellers', 'password')) {
                $table->string('password')->nullable();
            }
            if (!Schema::hasColumn('sellers', 'remember_token')) {
                $table->rememberToken();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('sellers', 'email')) {
                $columnsToDrop[] = 'email';
            }
            if (Schema::hasColumn('sellers', 'email_verified_at')) {
                $columnsToDrop[] = 'email_verified_at';
            }
            if (Schema::hasColumn('sellers', 'password')) {
                $columnsToDrop[] = 'password';
            }
            if (Schema::hasColumn('sellers', 'remember_token')) {
                $columnsToDrop[] = 'remember_token';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
