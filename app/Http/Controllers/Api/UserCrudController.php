<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserCrudController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $users = User::all();
        return response()->json(compact('users'));
    }


    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['message' => 'User created successfully']);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json(compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
