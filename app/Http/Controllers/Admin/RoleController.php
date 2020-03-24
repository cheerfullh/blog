<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Permission;
use App\Model\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = Role::get();
        return  view('admin.role.list',compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permission = Permission::get();
        return  view('admin.role.add',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rol_id = Role::insertGetId(['role_name'=>$request['role_name']]);
       foreach ($request['id'] as $v){
            $res =  \DB::table('role_permission')->insert(['role_id'=>$rol_id,'permission_id'=>$v]);
       }
        if ($res){
            $data = [
                'status'=>1,
                'message'=>'添加成功'
            ];
        }else{
            $data = [
                'status'=>0,
                'message'=>'添加失败'
            ];
        }
        return $data;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role = Role::find($id);
        $permission = Permission::get();
        $own_perms = $role->permission;
        $own_pers = [];
        foreach ($own_perms as $v){
            $own_pers[] = $v->id;
        }
        return view('admin.role.edit',compact('role','permission','own_pers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $role = Role::find($id);
        $role->role_name = $request['role_name'];
         $role->save();
        \DB::table('role_permission')->where('role_id',$id)->delete();
        //添加新授予的权限
        if(!empty($request['permission_id'])){
            foreach ($request['permission_id'] as $v){
                $res =\DB::table('role_permission')->insert(['role_id'=>$id,'permission_id'=>$v]);
            }
        }
        if ($res){
            $data = [
                'status'=>1,
                'message'=>'修改成功'
            ];
        }else{
            $data = [
                'status'=>0,
                'message'=>'修改失败'
            ];
        }
            return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $role = Role::find($id);
        \DB::table('role_permission')->where('role_id',$id)->delete();
        $res  = $role->delete();
        if ($res){
            $data = [
                'status'=>1,
                'message'=>'删除成功'
            ];
        }else{
            $data = [
                'status'=>0,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }
}
