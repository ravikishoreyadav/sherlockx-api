<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return  UserResource::collection(User::all()->keyBy->id);
    }

    public function create(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' =>  $validator->errors()
            ], 500);
        } else {

            $user = User::create([
                'name'  => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $user_role = Role::where(['name' => 'User'])->first();

            if ($user_role) {
                $user->assignRole($user_role);
            }

            return new UserResource($user);
        }
    }

    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required',
            'roles' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Validation errors.',
                'data' =>  $validator->errors()
            ], 500);
        } else {

            $input = $request->all();

            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }

            $user = User::find($id);
            $user->update($input);

            DB::table('model_has_roles')->where('model_id', $id)->delete();

            $user->assignRole($request->input('roles'));

            return new UserResource($user);
        }
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully.',
            'data' =>  ''
        ], 200);
    }
}
