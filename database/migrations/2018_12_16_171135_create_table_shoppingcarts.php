<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShoppingcarts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppingcarts', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable()->unique();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->timestamps();
        });

        DB::unprepared('CREATE TRIGGER `InsertShoppingcarts` BEFORE INSERT ON `shoppingcarts` FOR EACH ROW BEGIN 
            SET NEW.created_at = NOW();
            IF NEW.uuid = "" OR NEW.uuid IS NULL THEN
                SET NEW.uuid = UUID();
            END IF;	
        END');

        DB::unprepared('CREATE TRIGGER `UpdateShoppingcarts` BEFORE INSERT ON `shoppingcarts` FOR EACH ROW BEGIN
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
        Schema::dropIfExists('shoppingcarts');
        DB::unprepared('DROP TRIGGER `InsertShoppingcarts`');
        DB::unprepared('DROP TRIGGER `UpdateShoppingcarts`');
    }
}
