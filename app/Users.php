<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    private $tablename = 'users';

    /**
     * @param $userid
     * @return bool
     */
    public function checkUserId($userid)
    {
        return DB::table($this->tablename)->where('id', '=', $userid)->exists();
    }
}