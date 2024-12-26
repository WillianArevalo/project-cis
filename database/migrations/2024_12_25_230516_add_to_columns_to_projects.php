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
        Schema::table('projects', function (Blueprint $table) {
            $table->text("benefited_population")->nullable();
            $table->string("general_objective")->nullable();
            $table->text("justification")->nullable();
            $table->text("location")->nullable();
            $table->string("map")->nullable();
            $table->string("contextualization")->nullable();
            $table->string("description_activities")->nullable();
            $table->string("projections")->nullable();
            $table->string("challenges")->nullable();
            $table->string("schedule")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {});
    }
};
