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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('principal_id')->nullable(); 
            $table->foreign('principal_id')->references('id')->on('principals'); 
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->unsignedBigInteger('principal_id')->nullable(); 
            $table->foreign('principal_id')->references('id')->on('principals'); 
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['principal_id']); 
            $table->dropColumn('principal_id'); 
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['principal_id']); 
            $table->dropColumn('principal_id');
        });
    }
};
