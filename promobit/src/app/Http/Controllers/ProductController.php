<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
    
        return view('products.products', ['products' => $products]);
    }

    public function delete($id) {

        if(User::find(Auth::user()->id)){
            if(Product::find($id)) {
                Product::find($id)->delete();

                return redirect()->back()->with('msg', 'Produto excluído com sucesso');
            } else {
                return response(['message' => 'Produto não encontrado'], 404);
            }
        } else {
            return response(['message' => 'Você não tem permissão para deletar um producte!'], 404);
        }
    }

    public function createForm() {
        return view('products.create');
    }

    public function create(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Erro de validação']);
        }

        //cria o usuário
        $product = Product::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('msg', 'Produto criado com sucesso!');
    }

    public function editForm($id) {
        $product = Product::findOrFail($id);
        if($product){
            return view('products.edit', ['product' => $product]);
        } else {
            $product = '';
            return view('products.edit', ['product' => $product]);
        }

    }

    public function edit(Request $request, $id){
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
            return redirect()->back()->with('msg', 'Produto editado com sucesso!');
        } else {
            return response(['message' => 'Você não tem permissão para atualizar um producte!'], 400);
        }
    }

    public function tags($id){
        $product = Product::findOrFail($id);

        if($product){
            $product_tags = $product->tags;

            foreach($product_tags as $tag) {
                $tags[] = $tag->tag;
            }

            return view('products.tags', ['tags' => $tags, 'product' => $product]);
        } else {
            $product = '';
            return view('products.tags', ['tags' => $tags, 'product' => $product]);
        }
    }
}
