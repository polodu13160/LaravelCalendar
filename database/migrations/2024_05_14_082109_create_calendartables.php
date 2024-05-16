<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {

        Schema::create('addressbookchanges', function (Blueprint $table) {
            $table->id();
            $table->binary('uri', 200);
            $table->unsignedInteger('synctoken');
            $table->unsignedInteger('addressbookid');
            $table->tinyInteger('operation');
            $table->index(['addressbookid', 'synctoken']);
            // $table->charset = 'utf8mb4';
            // $table->engine = 'InnoDB';
        });
       
        Schema::create('calendarobjects', function (Blueprint $table) {
            $table->id();
            $table->binary('uri', 200)->nullable();
            $table->unsignedInteger('calendarid');
            $table->unsignedInteger('lastmodified')->nullable();
            $table->binary('etag', 32)->nullable();
            $table->unsignedInteger('size');
            $table->binary('componenttype', 8)->nullable();
            $table->unsignedInteger('firstoccurence')->nullable();
            $table->unsignedInteger('lastoccurence')->nullable();
            $table->binary('uid', 200)->nullable();
            $table->unique(['calendarid', 'uri']);
            $table->index(['calendarid', 'firstoccurence']);
            // $table->charset = 'utf8mb4';
            // $table->engine = 'InnoDB';
        });
        DB::statement("ALTER TABLE calendarobjects ADD calendardata MEDIUMBLOB");
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('synctoken')->default(1);
            $table->binary('components', 21)->nullable();
            // $table->charset = 'utf8mb4';
            // $table->engine = 'InnoDB';
        });
        Schema::create(
            'calendarinstances',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('calendarid');
                $table->binary('principaluri', 100)->nullable();
                $table->tinyInteger('access')->default(1)->comment('1 = owner, 2 = read, 3 = readwrite');
                $table->string('displayname', 100)->nullable();
                $table->binary('uri', 200)->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('calendarorder')->default(0);
                $table->binary('calendarcolor', 10)->nullable();
                $table->text('timezone')->nullable();
                $table->tinyInteger('transparent')->default(0);
                $table->binary('share_href', 100)->nullable();
                $table->string('share_displayname', 100)->nullable();
                $table->tinyInteger('share_invitestatus')->default(2)->comment('1 = noresponse, 2 = accepted, 3 = declined, 4 = invalid');
                $table->unique(['principaluri', 'uri']);
                $table->unique(['calendarid', 'principaluri']);
                $table->unique(['calendarid', 'share_href']);
                // $table->charset = 'utf8mb4';
                // $table->engine = 'InnoDB';
    });
        Schema::create('calendarchanges', function (Blueprint $table) {
            $table->id();
            $table->binary('uri', 200);
            $table->unsignedInteger('synctoken');
            $table->unsignedInteger('calendarid');
            $table->tinyInteger('operation');
            $table->index(['calendarid', 'synctoken']);
            // $table->charset = 'utf8mb4';
            // $table->engine = 'InnoDB';
        });
        Schema::create('calendarsubscriptions', function (Blueprint $table) {
            $table->id();
            $table->binary('uri', 200);
            $table->binary('principaluri', 100);
            $table->text('source')->nullable();
            $table->string('displayname', 100)->nullable();
            $table->string('refreshrate', 10)->nullable();
            $table->unsignedInteger('calendarorder')->default(0);
            $table->binary('calendarcolor', 10)->nullable();
            $table->tinyInteger('striptodos')->nullable();
            $table->tinyInteger('stripalarms')->nullable();
            $table->tinyInteger('stripattachments')->nullable();
            $table->unsignedInteger('lastmodified')->nullable();
            $table->unique(['principaluri', 'uri']);
            // $table->charset = 'utf8mb4';
            // $table->engine = 'InnoDB';
        });
        Schema::create('schedulingobjects', function (Blueprint $table) {
            $table->id();
            $table->binary('principaluri', 255)->nullable();
            $table->binary('uri', 200)->nullable();
            $table->unsignedInteger('lastmodified')->nullable();
            $table->binary('etag', 32)->nullable();
            $table->unsignedInteger('size');
            $table->charset = 'utf8mb4';
            $table->engine = 'InnoDB';
        });
        DB::statement("ALTER TABLE schedulingobjects ADD calendardata MEDIUMBLOB");

        Schema::create('locks', function (Blueprint $table) {
            $table->id();
            $table->string('owner', 100)->nullable();
            $table->unsignedInteger('timeout')->nullable();
            $table->unsignedInteger('created')->nullable();
            $table->binary('token', 100)->nullable();
            $table->tinyInteger('scope')->nullable();
            $table->tinyInteger('depth')->nullable();
            $table->binary('uri', 1000)->nullable();
            $table->index('token');
            $table->index('uri');
            $table->charset = 'utf8mb4';
            $table->engine = 'InnoDB';
        });
        Schema::create('principals', function (Blueprint $table) {
            $table->id();
            $table->binary('uri', 200);
            $table->binary('email', 80)->nullable();
            $table->string('displayname', 80)->nullable();
            $table->unique('uri');
            $table->charset = 'utf8mb4';
            $table->engine = 'InnoDB';
        });

        // DB::table('principals')->insert([
        //     ['uri' => 'principals/admin', 'email' => 'admin@example.org', 'displayname' => 'Administrator'],
        //     ['uri' => 'principals/admin/calendar-proxy-read', 'email' => null, 'displayname' => null],
        //     ['uri' => 'principals/admin/calendar-proxy-write', 'email' => null, 'displayname' => null],
        // ]);
        Schema::create('groupmembers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('principal_id');
            $table->unsignedInteger('member_id');
            $table->unique(['principal_id', 'member_id']);
            // $table->charset = 'utf8mb4';
            // $table->engine = 'InnoDB';
        });
        Schema::create('propertystorage', function (Blueprint $table) {
            $table->id();
            $table->binary('path', 1024);
            $table->binary('name', 100);
            $table->unsignedInteger('valuetype')->nullable();
        });
        DB::statement("ALTER TABLE propertystorage ADD value MEDIUMBLOB NULL");
        DB::statement('CREATE UNIQUE INDEX path_property ON propertystorage (path(600), name(100))');
    }

    public function down()
    {
        Schema::dropIfExists('addressbookchanges');
        Schema::dropIfExists('calendarobjects');
        Schema::dropIfExists('calendars');
        Schema::dropIfExists('calendarinstances');
        Schema::dropIfExists('calendarchanges');
        Schema::dropIfExists('calendarsubscriptions');
        Schema::dropIfExists('schedulingobjects');
        Schema::dropIfExists('locks');
        Schema::dropIfExists('principals');
        Schema::dropIfExists('groupmembers');
        Schema::dropIfExists('propertystorage');
    
    }
};
