<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->string('submission_type')->default('entry')->after('category_id')->index();
            $table->json('payload')->nullable()->after('content');
            $table->string('target_model')->nullable()->after('payload');
            $table->unsignedBigInteger('target_id')->nullable()->after('target_model');
        });
    }

    public function down(): void
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->dropColumn([
                'submission_type',
                'payload',
                'target_model',
                'target_id',
            ]);
        });
    }
};
