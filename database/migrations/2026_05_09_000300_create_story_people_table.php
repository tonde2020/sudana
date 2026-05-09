<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story_people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();
            $table->foreignId('locality_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('name_fr')->nullable();
            $table->string('slug')->unique();
            $table->string('headline_ar')->nullable();
            $table->string('headline_en')->nullable();
            $table->string('headline_fr')->nullable();
            $table->longText('bio_ar')->nullable();
            $table->longText('bio_en')->nullable();
            $table->longText('bio_fr')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedSmallInteger('birth_year')->nullable();
            $table->unsignedSmallInteger('death_year')->nullable();
            $table->string('source_name')->nullable();
            $table->string('source_url')->nullable();
            $table->string('status')->default('draft')->index();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_people');
    }
};
