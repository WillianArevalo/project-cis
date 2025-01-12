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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("photo")->nullable();
            $table->string("institution")->nullable();
            $table->string("academic_level")->nullable();
            $table->string("career")->nullable();
            $table->string("study_level")->nullable();
            $table->string("phone")->nullable();
            $table->foreignId("community_id")->constrained();
            $table->foreignId("project_id")->nullable()->constrained();
            $table->foreignId("user_id")->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
