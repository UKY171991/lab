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
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn(['auto_suggestion', 'age_gender_wise_ref_range', 'print_on_new_page', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->boolean('auto_suggestion')->default(false);
            $table->boolean('age_gender_wise_ref_range')->default(false);
            $table->boolean('print_on_new_page')->default(false);
            $table->integer('sort_order')->default(0);
        });
    }
};
