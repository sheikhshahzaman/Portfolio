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
        Schema::create('translation_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key'); // e.g., "nav.home", "hero.title"
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->text('value'); // The translated text
            $table->string('group')->default('general'); // e.g., "nav", "hero", "footer"
            $table->text('description')->nullable(); // Optional description for admins
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
        Schema::dropIfExists('translation_keys');
    }
};
