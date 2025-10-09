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
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();

            $table->unique(['key', 'language_id']);
            $table->index(['group', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_translations');
    }
};
