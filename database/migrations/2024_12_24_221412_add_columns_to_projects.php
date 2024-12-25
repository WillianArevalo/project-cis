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
            $table->boolean("accept")->default(false);
            $table->string("document")->nullable();
            $table->foreignId("sent_by")->nullable()->constrained("users")->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn("accept");
            $table->dropColumn("document");
            $table->dropForeign(["sent_by"]);
            $table->dropColumn("sent_by");
        });
    }
};