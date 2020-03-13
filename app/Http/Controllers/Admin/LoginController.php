<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Org\code\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    //登陆页
    public function login()
    {
        return view('admin.login');
    }

    //验证码
    public function code()
    {
        $code = new Code();
        return $code->make();
    }

//    表单登陆验证
    public function store(Request $request)
    {
        $rule = [
            'username' => 'required|between:4,18',
            'password' => 'required|between:6,18',
        ];
        $msg = [
            'username.required'=>'用户名不能为空',
            'username.between'=>'用户名在4-18之间',
            'password.required'=>'密码不能为空',
            'password.between'=>'密码在6-18之间',
        ];
        $validatedData = $request->validate($rule,$msg);

        $user = User::where('user_name',$request['username'])->first();
        if (!$user){
            return redirect('admin/login')->with('errors','用户名不存在');
        }
        if ($request['password'] != Crypt::decrypt($user['user_pass'])){
            return redirect('admin/login')->with('errors','密码错误');
        }
        if (strtolower($request['code']) != strtolower(session('code'))){
            return redirect('admin/login')->with('errors','验证码错误');
        }
        session(['user' => $user]);
        return redirect('admin/index');

    }
    public function index(){
        return view('admin/index');
    }
    public function welcome(){
        return view('admin/welcome');
    }
    public function logout(){
        session()->flush();
        return view('admin/login');
    }
}
