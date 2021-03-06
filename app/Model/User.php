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
    public $guarded = [];
    //    public $fillable = ['user_name','user_pass','email','phone'];
//更新时间
    public $timestamps = false;


    //添加动态属性，关联权限模型
    public function roles()
    {
        return $this->belongsToMany('App\Model\Role','user_role','user_id','role_id');
    }
}
