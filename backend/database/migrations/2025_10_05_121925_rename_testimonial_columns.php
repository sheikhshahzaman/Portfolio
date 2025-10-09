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
        Schema::table('testimonials', function (Blueprint $table) {
            $table->renameColumn('name', 'client_name');
            $table->renameColumn('position', 'client_position');
            $table->renameColumn('company', 'client_company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->renameColumn('client_name', 'name');
            $table->renameColumn('client_position', 'position');
            $table->renameColumn('client_company', 'company');
        });
    }
};
