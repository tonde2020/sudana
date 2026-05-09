<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();
            $table->foreignId('locality_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('story_person_id')->nullable()->constrained('story_people')->nullOnDelete();
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('story_type')->default('story')->index();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->string('title_fr')->nullable();
            $table->string('slug')->unique();
            $table->text('summary_ar')->nullable();
            $table->text('summary_en')->nullable();
            $table->text('summary_fr')->nullable();
            $table->longText('content_ar')->nullable();
            $table->longText('content_en')->nullable();
            $table->longText('content_fr')->nullable();
            $table->text('interpretation_ar')->nullable();
            $table->text('interpretation_en')->nullable();
            $table->text('interpretation_fr')->nullable();
            $table->string('narrator_name')->nullable();
            $table->string('source_name')->nullable();
            $table->string('source_url')->nullable();
            $table->string('audio_path')->nullable();
            $table->string('image_path')->nullable();
            $table->string('audience_age_group')->nullable();
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
        Schema::dropIfExists('stories');
    }
};
