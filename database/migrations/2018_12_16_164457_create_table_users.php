<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable()->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->timestamps();
        });

        DB::unprepared('CREATE TRIGGER `InsertUsers` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
	        SET NEW.created_at = NOW();
            IF NEW.uuid = "" OR NEW.uuid IS NULL THEN
                SET NEW.uuid = UUID();
            END IF;	
        END');

        DB::unprepared('CREATE TRIGGER `UpdateUsers` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
	        SET NEW.updated_at = NOW();
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        DB::unprepared('DROP TRIGGER `InsertUsers`');
        DB::unprepared('DROP TRIGGER `UpdateUsers`');
    }
}
