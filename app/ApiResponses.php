<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ApiResponses extends Model
{

    /**
     * @param $tablename
     * @return array
     */
    public function getTableContent($tablename)
    {
        return DB::select("SELECT * FROM $tablename");
    }

    /**
     * @param $data
     * @return bool|string
     */
    public function addTableContent($data)
    {
        $tablename = $data['tablename'];
        $tabledata = $data['data'];

        if (!Schema::hasTable($tablename)) {
            return 'Database table not exist.';
        }

        return DB::table($tablename)->insert($tabledata);
    }

    /**
     * @param $data
     * @return \Illuminate\Support\Collection|string
     */
    public function getUserCart($data)
    {
        $cartModel = new Shoppingcarts();

        if (!$cartModel->checkUserid($data['user_id'])) {
            return 'Invalid user ID, user not found on shopping cart.';
        } else {
            return $cartModel->getCarts($data['user_id']);
        }
    }

    /**
     * @param $data
     * @return bool|string
     */
    public function setUserCart($data)
    {
        $cartModel = new Shoppingcarts();
        $userModel = new Users();
        $productModel = new Products();

        if (!$userModel->checkUserid($data['user_id'])) {
            return 'Invalid user ID, user not found.';
        }

        if (!$productModel->checkProductId($data['product_id'])) {
            return 'Invalid product ID, product not found.';
        }

        if (!$cartModel->checkUserProduct($data)) {
            return $cartModel->insertItem($data);
        } else {
            return $cartModel->updateItem($data);
        }

    }

    /**
     * @param $Data
     * @param $Required
     * @return bool
     */
    public function DataCheck($Data, $Required)
    {
        if (!array_diff($Required, array_keys($Data))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}