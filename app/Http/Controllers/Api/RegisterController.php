<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        //create user
        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //Assign role to user
        $user_role = Role::where(['name'=>'User'])->first();

        if($user_role){
            $user->assignRole($user_role);
        }

        return new UserResource($user);
    }
}
