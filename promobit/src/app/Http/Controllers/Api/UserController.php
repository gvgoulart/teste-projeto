<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required'],
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Erro de validação']);
        }

        //cria o usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response([ 'user' => $user, 'message' => 'Criado com sucesso'], 200);
    }

    public function getAll() {
        $users = User::all();

        return response(['users' => $users], 200);
    }

    public function getUser($id) {
        if (User::where('id', $id)->exists()) {
            $user = User::findOrFail($id);
            return response(['user' => $user], 200);
        } else {
            return response(['message' => 'Usuário não encontrado!'], 404);
        }
    }

    public function edit(Request $request,$id) {
        if(User::find(Auth::user()->id)){
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
            ]);

            if($validator->fails()){
                return response(['error' => $validator->errors(), 'Erro de validação']);
            }

            $name = $request->name;
            $email = $request->email;

            User::find($id)->update([
                'name'=>$name,
                'email'=>$email,
            ]);
            $user = User::find($id);

            $user->save();
            return  response([ 'message' => 'Editado com sucesso'], 200);
        } else {
            return response(['message' => 'Você não tem permissão para atualizar um usuário!'], 400);
        }
    }

    public function delete($id) {

        if(User::find(Auth::user()->id)){
            if(User::find($id)) {
                User::find($id)->delete();

                return  response([ 'message' => 'Excluído com sucesso'], 200);
            } else {
                return response(['message' => 'Usuário não encontrado'], 404);
            }
        } else {
            return response(['message' => 'Você não tem permissão para deletar um usuário!'], 404);
        }
    }
}
