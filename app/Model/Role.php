<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //表名
    public $table = 'role';
//    主键
    public $primaryKey = 'id';
//批量处理
    public $guarded = [];
    //    public $fillable = ['user_name','user_pass','email','phone'];
//更新时间
    public $timestamps = false;

    //添加动态属性，关联权限模型
    public function permission()
    {
        return $this->belongsToMany('App\Model\Permission','role_permission','role_id','permission_id');
    }
}
