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
            $table->foreign('principal_id')->references('id')->on('principals')->onDelete('set null');
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->unsignedBigInteger('principal_id')->nullable();
            $table->foreign('principal_id')->references('id')->on('principals')->onDelete('set null');
        });
        Schema::table('calendarobjects', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('calendarobject_id')->nullable();
            $table->foreign('calendarobject_id')->references('id')->on('calendarobjects')->onDelete('set null');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('calendar_id')->nullable();
            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('set null');
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
        Schema::table('calendarobjects', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['calendarobject_id']);
            $table->dropColumn('calendarobject_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('calendar_id');
            $table->dropColumn('calendar_id');
        });
    }
};
