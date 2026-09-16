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
        Schema::create('automation_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('run_at');
            $table->string('slot');
            $table->string('category')->nullable();
            $table->string('topic')->nullable();
            $table->unsignedBigInteger('blog_post_id')->nullable();
            $table->string('blog_url')->nullable();
            $table->integer('word_count')->nullable();
            $table->boolean('linkedin_attempted')->default(false);
            $table->boolean('linkedin_posted')->default(false);
            $table->string('linkedin_post_url')->nullable();
            $table->string('status');
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automation_logs');
    }
};
