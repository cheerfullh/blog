<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //表名
    public $table = 'user';
//    主键
    public $primaryKey = 'user_id';
//批量处理
    public $guarded=[];
//更新时间
    public $timestamps = false;
}
