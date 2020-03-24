<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //表名
    public $table = 'permission';
//    主键
    public $primaryKey = 'id';
//批量处理
    public $guarded = [];
    //    public $fillable = ['user_name','user_pass','email','phone'];
//更新时间
    public $timestamps = false;
}
