<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(Request $request) {
        if (User::where('email', $request->email)->exists()) {

            $data = $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            if (!Auth::attempt($data)) {
                return response(['error' => ['msg' => 'Credenciais inválidas!']], 401);
            }

            $accessToken = Auth::user()->createToken('authToken')->accessToken;

            return response(['user' => Auth::user(), 'access_token' => $accessToken]);

        } else {
            return response(['error' => ['msg' => 'Usuário não encontrado!']], 401);
        }
    }

    public function logout(Request $request) {
        $isUser = $request->user()->token()->revoke();
        if($isUser) {
            $resposta['message'] = 'Logout efetuado com sucesso';
            return response()->json($resposta, 200);
        } else {
            $resposta = "Algo deu errado";
            return response()->json($resposta, 404);
        }
    }
}
