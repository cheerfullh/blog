<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    //表名
    public $table = 'category';
//    主键
    public $primaryKey = 'cate_id';
//批量处理
    public $guarded = [];
    //    public $fillable = ['user_name','user_pass','email','phone'];
//更新时间
    public $timestamps = false;
}
