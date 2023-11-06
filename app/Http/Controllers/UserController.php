<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserStoreRequest;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // Return Json Response
        return response()->json([
            'results' => $users
        ], 200);
    }

    public function show($id)
    {
        // User Detail 
        $users = User::find($id);
        if (!$users) {
            return response()->json([
                'message' => 'User Not Found.'
            ], 404);
        }

        // Return Json Response
        return response()->json([
            'users' => $users
        ], 200);
    }


    public function store(UserStoreRequest $request)
    {
        try {
            //buat user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return response()->json([
                'message' => "User successfully created."
            ], 200);
        } catch (\Exception $e) {
            return response()->json(
                ['message' => "something went really wrong!"],
                500
            );
        }
    }

    public function update(UserStoreRequest $request, $id)
    {
        try {
            $users = User::find($id);
            if (!$users) {
                return response()->json([
                    'message' => 'User Not Found.'
                ], 404);
            }
            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = $request->password;

            //update user
            $users->save();

            return response()->json([
                'message' => "Berhasil Update"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Something went really wrong"
            ], 500);
        }
    }

    public function destroy($id)
    {
        $users = User::find($id);
        if (!$users) {
            return response()->json([
                'message'=> 'User Not Found'
            ],404);
        }
        
        //hapus user
        $users->delete();


        return response()->json([
        'message'=> 'Berhasil Dihapus'
        ],200);
    }
}
