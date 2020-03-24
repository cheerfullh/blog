<?php

namespace App\Http\Middleware;

use App\Model\Role;
use App\Model\User;
use Closure;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role =\Route::current()->getActionName();
        $user_id = session()->get('user')->user_id;
        $user =User::find($user_id);
        $roles  =  $user->roles;
        $arr = [];
        foreach ($roles as $v){
            $perm = $v->permission;
            foreach ($perm as $perms){
                $arr[] =$perms->per_url;
            }
        }
        $arr =array_unique($arr);
        if (in_array($role,$arr)){
            return $next($request);
        }else{
            return redirect('noaccess');
        }

    }
}
