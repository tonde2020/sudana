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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('state_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('role')->default('citizen')->after('password');
            $table->text('bio')->nullable()->after('role');
            $table->boolean('is_active')->default(true)->after('bio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('state_id');
            $table->dropColumn(['role', 'bio', 'is_active']);
        });
    }
};
