<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Role;
use \App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $user = User::orderBy('user_id','asc')
            ->where(function ($query) use ($request){
                $username = $request->input('username');
                $email = $request->input('email');
                if(!empty($username)){
                    $query->where('user_name','like','%'.$username.'%');
                }
                if(!empty($email)){
                    $query->where('email','like','%'.$email.'%');
                }
            })
            ->paginate($request->input('num')?$request->input('num'):3);
        return view('admin.user.list',compact('user','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $role = Role::get();
        return view('admin.user.add',compact('role'));
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
        $pass = Crypt::encrypt($request['pass']);
        $user_id= User::insertGetId(['user_name'=>$request['username'],'user_pass'=>$pass,'email'=>$request['email']]);
        if (!empty($request['role_id'])){
            foreach ($request['role_id'] as $v){
                $res =  \DB::table('user_role')->insert(['user_id'=>$user_id,'role_id'=>$v]);
            }
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
        $user = User::find($id);
        $role = Role::get();
        $sel_role = $user->roles;
        $role_id = [];
        foreach ($sel_role as $v){
            $role_id[] = $v['id'];
        }
        return view('admin.user.edit',compact('user','role','role_id'));
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
        $user = User::find($id);
        $user->user_name = $request['username'];
        $user->email = $request['email'];
        $res = $user->save();
        \DB::table('user_role')->where('user_id',$id)->delete();
        //添加新授予的权限
        if(!empty($request['role_id'])){
            foreach ($request['role_id'] as $v){
                $res =\DB::table('user_role')->insert(['user_id'=>$id,'role_id'=>$v]);
            }
        }
        if ($res){
            $data = [
              'status'=>1,
              'message'=> '修改成功'
            ];
        }else{
            $data = [
                'status'=>0,
                'message'=> '修改失败'
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
        $user = User::find($id);
        $res = $user->delete();
        \DB::table('user_role')->where('user_id',$id)->delete();
        if ($res){
            $data = [
                'status'=>1,
                'message'=> '删除成功'
            ];
        }else{
            $data = [
                'status'=>0,
                'message'=> '删除失败'
            ];
        }
        return $data;
    }
//    批量删除
    public function delAll(Request $request)
    {
        //
        $res = User::destroy($request['ids']);
        if ($res){
            $data = [
                'status'=>1,
                'message'=> '删除成功'
            ];
        }else{
            $data = [
                'status'=>0,
                'message'=> '删除失败'
            ];
        }
        return $data;
    }
}
