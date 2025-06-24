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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('test_name');
            $table->string('specimen')->nullable();
            $table->string('result_default')->nullable();
            $table->string('unit')->nullable();
            $table->string('reference_range')->nullable();
            $table->decimal('min_value', 10, 2)->nullable();
            $table->decimal('max_value', 10, 2)->nullable();
            $table->boolean('is_sub_heading')->default(false);
            $table->string('testcode')->nullable();
            $table->string('individual_method')->nullable();
            $table->boolean('auto_suggestion')->default(false);
            $table->boolean('age_gender_wise_ref_range')->default(false);
            $table->boolean('print_on_new_page')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
