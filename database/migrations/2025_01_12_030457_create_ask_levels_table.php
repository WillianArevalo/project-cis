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
        Schema::create('ask_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ask_id')->constrained()->cascadeOnDelete();
            $table->string("level")->example("Universidad");
            $table->enum("type", ["new_entry", "old_entrance"])->example("new_entry");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ask_levels');
    }
};