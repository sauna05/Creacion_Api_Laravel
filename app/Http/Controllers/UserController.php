<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function users(Request $request){
        $users = User::all();
        if ($users) 
        {
            return  response()->json($users);
            
        } else {
           return  response()->json(["message"=> "usuarios no existen"],201);
        }
        
    }
    public function register(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "unique:users,email"],
            "password" => ["required", "string", "min:8"],
        ],[
            "name.requiered"=>"este campo es requerido"
        ]
    );

        // Crear el usuario
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password) // Usar Hash::make para mayor claridad
        ]);

        // Retornar respuesta JSON
        return response()->json([
            "message" => "Usuario registrado exitosamente",
            "user" => $user
        ], 201);
    }

    public function login(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);

        // Buscar el usuario por email
        $user = User::where("email", $request->email)->first();

        // Verificar las credenciales
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "email" => ["Las credenciales proporcionadas son incorrectas."]
            ]);
        }

        // Crear un token de acceso
        $token = $user->createToken("auth_token")->plainTextToken;
        // Retornar respuesta JSON con el token
        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "user" => $user
        ]);
    }

    public function logout(Request $request)
    {
        // Eliminar el token actual del usuario
        $request->user()->currentAccessToken()->delete();

        // Retornar respuesta JSON
        return response()->json([
            "message" => "Sesión cerrada exitosamente"
        ]);
    }
}