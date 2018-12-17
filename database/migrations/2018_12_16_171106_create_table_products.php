<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable()->unique();
            $table->string('name')->unique();
            $table->string('price');
            $table->string('currency');
            $table->timestamps();
        });

        DB::unprepared('CREATE TRIGGER `InsertProducts` BEFORE INSERT ON `products` FOR EACH ROW BEGIN 
	        SET NEW.created_at = NOW();
            IF NEW.uuid = "" OR NEW.uuid IS NULL THEN
                SET NEW.uuid = UUID();
            END IF;	
        END');

        DB::unprepared('CREATE TRIGGER `UpdateProducts` BEFORE INSERT ON `products` FOR EACH ROW BEGIN 
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
        Schema::dropIfExists('products');
        DB::unprepared('DROP TRIGGER `InsertProducts`');
        DB::unprepared('DROP TRIGGER `UpdateProducts`');
    }
}
