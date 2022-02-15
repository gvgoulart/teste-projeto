<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $product = Product::create([
            'name' => $request->name,
        ]);

        return response(['product' => $product, 'message' => 'Produto criado com sucesso'], 200);
    }

    public function getAll() {
        $product = Product::all();

        return response(['product' => $product], 200);
    }

    public function getProduct($id) {
        if (Product::where('id', $id)->exists()) {
            $product = Product::findOrFail($id);
            return response(['product' => $product], 200);
        } else {
            return response(['message' => 'Produto não encontrado!'], 404);
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

            Product::find($id)->update([
                'name'=>$name
            ]);

            $product = Product::find($id);

            $product->save();
            return  response([ 'message' => 'Produto editado com sucesso'], 200);
        } else {
            return response(['message' => 'Você não tem permissão para atualizar um product!'], 400);
        }
    }

    public function delete($id) {

        if(User::find(Auth::user()->id)){
            if(Product::find($id)) {
                Product::find($id)->delete();

                return  response([ 'message' => 'Produto excluído com sucesso'], 200);
            } else {
                return response(['message' => 'Produto não encontrado'], 404);
            }
        } else {
            return response(['message' => 'Você não tem permissão para deletar um product!'], 404);
        }
    }

    public function insertOtherTag(Request $request, $product_id){ 
        if (Tag::where('id', $request->tag_id)->exists()) {             
            if (Product::where('id', $product_id)->exists()) {                 
                $product = Product::findOrFail($product_id);                  
                $product_tag = ProductTag::where('product_id', '=', $product_id)->where('tag_id', '=', $request->atual_tag_id);                  
                if($product_tag) {                     
                    $product_tag->update([                         
                        'tag_id' => $request->tag_id                     
                    ]);                      
                    return  response([ 'message' => 'Produto editado com sucesso'], 200);                 
                } else {                     
                    return response(['message' => 'Relacionamento não encontrado!'], 404);                 
                }             
            } else {                 
                return response(['message' => 'Produto não encontrado!'], 404);             
            }         
        } else {             
            return response(['message' => 'Tag não existe!'], 404);         
        }     
    }
}
