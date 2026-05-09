<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();
            $table->foreignId('locality_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('office_id')->nullable()->constrained('investment_offices')->nullOnDelete();
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->string('title_fr')->nullable();
            $table->string('slug')->unique();
            $table->text('summary_ar')->nullable();
            $table->text('summary_en')->nullable();
            $table->text('summary_fr')->nullable();
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_fr')->nullable();
            $table->string('investment_type')->nullable();
            $table->string('readiness_status')->nullable();
            $table->string('capital_range')->nullable();
            $table->text('expected_roi_notes')->nullable();
            $table->text('infrastructure_notes_ar')->nullable();
            $table->text('infrastructure_notes_en')->nullable();
            $table->text('infrastructure_notes_fr')->nullable();
            $table->text('incentives_ar')->nullable();
            $table->text('incentives_en')->nullable();
            $table->text('incentives_fr')->nullable();
            $table->text('risks_ar')->nullable();
            $table->text('risks_en')->nullable();
            $table->text('risks_fr')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('draft')->index();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('source_name')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_opportunities');
    }
};
