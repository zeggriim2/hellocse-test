<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Administrateur;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $admin = new Administrateur();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);

        $admin->save();


        return response()->json(['message' => 'Admin created successfully'], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        if (auth()->attempt($request->only('email', 'password'))) {
            $admin = auth()->user();

            $token = $admin->createToken('MA_CLE_SECRET')->plainTextToken;
            return response()->json(['token' => $token],
                Response::HTTP_OK
            );
        } else {
            return response()->json(['message' => 'Unauthorized'],
                Response::HTTP_FORBIDDEN
            );
        }
    }
}
