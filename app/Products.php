<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    private $tablename = 'products';

    /**
     * @param $productid
     * @return bool
     */
    public function checkProductId($productid)
    {
        return DB::table($this->tablename)->where('id', '=', $productid)->exists();
    }
}