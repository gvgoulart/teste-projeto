<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\User;
use App\Models\ProductTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:50',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Erro de validação']);
        }

        //cria o usuário
        $tag = Tag::create([
            'name' => $request->name,
        ]);

        return response([ 'tag' => $tag, 'message' => 'Tag criada com sucesso'], 200);
    }

    public function getAll() {
        $tag = Tag::all();

        return response(['tag' => $tag], 200);
    }

    public function getTag($id) {
        if (Tag::where('id', $id)->exists()) {
            $tag = Tag::findOrFail($id);
            return response(['tag' => $tag], 200);
        } else {
            return response(['message' => 'Produto não encontrado!'], 404);
        }
    }

    public function getTagProducts($id) {
        if (Tag::where('id', $id)->exists()) {

            $tag = Tag::findOrFail($id);

            $products = DB::table('product_tags')
                ->where('tag_id', '=', $id)
                ->get();
            if(count($products) > 0) {
                return response([$tag->name => $products], 200);
            } else {
                return response(['message' => 'Não existe produto com essa tag'], 200);
            }
        } else {
            return response(['message' => 'Tag não encontrada!'], 404);
        }
    }
    
    public function edit(Request $request,$id) {
        if(User::find(Auth::user()->id)){
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|max:55'
            ]);

            if($validator->fails()){
                return response(['error' => $validator->errors(), 'Erro de validação']);
            }

            $name = $request->name;

            Tag::find($id)->update([
                'name'=>$name
            ]);

            $tag = Tag::find($id);

            $tag->save();
            return  response([ 'message' => 'Produto editado com sucesso'], 200);
        } else {
            return response(['message' => 'Você não tem permissão para atualizar um produto!'], 400);
        }
    }

    public function delete($id) {

        if(User::find(Auth::user()->id)){
            if(Tag::find($id)) {
                Tag::find($id)->delete();

                return  response([ 'message' => 'Produto excluído com sucesso'], 200);
            } else {
                return response(['message' => 'Produto não encontrado'], 404);
            }
        } else {
            return response(['message' => 'Você não tem permissão para deletar um produto!'], 404);
        }
    }
}
