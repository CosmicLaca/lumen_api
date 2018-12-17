<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product[] = ['name' => 'product_1', 'price' => 10, 'currency' => 'HUF'];
        $product[] = ['name' => 'product_2', 'price' => 20, 'currency' => 'HUF'];
        $product[] = ['name' => 'product_3', 'price' => 30, 'currency' => 'HUF'];
        $product[] = ['name' => 'product_4', 'price' => 40, 'currency' => 'HUF'];
        $product[] = ['name' => 'product_5', 'price' => 50, 'currency' => 'HUF'];
        DB::table('products')->insert($product);

        $user[] = ['username' => 'User_1', 'name' => 'user 1', 'email' => 'name_1@gmail.com', 'phone' => '06/70 11111-22222', 'password' => '123456'];
        $user[] = ['username' => 'User_2', 'name' => 'user 2', 'email' => 'name_2@gmail.com', 'phone' => '06/70 33333-44444', 'password' => '123456'];
        $user[] = ['username' => 'User_3', 'name' => 'user 3', 'email' => 'name_3@gmail.com', 'phone' => '06/70 5555-66666', 'password' => '123456'];
        DB::table('users')->insert($user);
    }
}
