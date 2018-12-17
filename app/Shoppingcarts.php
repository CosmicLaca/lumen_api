<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shoppingcarts extends Model
{
    private $tablename = 'shoppingcarts';

    /**
     * @param $data
     * @return bool
     */
    public function insertItem($data)
    {
        return DB::table($this->tablename)->insert($data);
    }

    /**
     * @param $data
     * @return bool
     */
    public function checkUserProduct($data)
    {
        return DB::table($this->tablename)->where('user_id', '=', $data['user_id'])
                                          ->where('product_id', '=', $data['product_id'])
                                          ->exists();
    }

    /**
     * @param $data
     * @return bool|string
     */
    public function updateItem($data)
    {
        $oldQty = DB::table($this->tablename)->where('user_id', '=', $data['user_id'])
                                             ->where('product_id', '=', $data['product_id'])
                                             ->pluck('quantity');

        $newQty = intval($oldQty[0] + $data['quantity']);

        $updatedRows = DB::table($this->tablename)->where('user_id', $data['user_id'])
                                                  ->where('product_id', '=', $data['product_id'])
                                                  ->update(array('quantity' => $newQty));

        if ($updatedRows == 1) {
            return TRUE;
        } else {
            return 'Shopping cart update error.';
        }
    }

    /**
     * @param $userid
     * @return bool
     */
    public function checkUserId($userid)
    {
        return DB::table($this->tablename)->where('user_id', '=', $userid)->exists();
    }

    /**
     * @param $userid
     * @return \Illuminate\Support\Collection
     */
    public function getCarts($userid) {
        return DB::table($this->tablename)
            ->select($this->tablename . '.user_id',
                    'users.username AS users_username',
                    'users.name AS users_name',
                    'users.email AS users_email',
                    $this->tablename . '.product_id',
                    'products.name AS products_name',
                    'products.price AS products_price',
                    $this->tablename . '.quantity',
                    DB::raw('products.price * ' . $this->tablename . '.quantity as total'),
                    'products.currency AS products_currency')
            ->join('users', $this->tablename . '.user_id', '=', 'users.id')
            ->join('products', $this->tablename . '.product_id', '=', 'products.id')
            ->where([$this->tablename . '.user_id' => $userid])
            ->get();
    }

}