<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
    
        return view('tags.tags', ['tags' => $tags]);
    }

    public function delete($id) {

        if(User::find(Auth::user()->id)){
            if(Tag::find($id)) {
                Tag::find($id)->delete();

                return redirect()->back()->with('msg', 'Tag excluído com sucesso');
            } else {
                return response(['message' => 'Tag não encontrado'], 404);
            }
        } else {
            return response(['message' => 'Você não tem permissão para deletar uma tag!'], 404);
        }
    }

    public function createForm() {
        return view('tags.create');
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
        $tag = Tag::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('msg', 'Tag criada com sucesso!');
    }

    public function editForm($id) {
        $tag = Tag::findOrFail($id);
        if($tag){
            return view('tags.edit', ['tag' => $tag]);
        } else {
            $tag = '';
            return view('tags.edit', ['tag' => $tag]);
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

            Tag::find($id)->update([
                'name'=>$name
            ]);

            $tag = Tag::find($id);

            $tag->save();
            return redirect()->back()->with('msg', 'Tag editado com sucesso!');
        } else {
            return response(['message' => 'Você não tem permissão para atualizar um tage!'], 400);
        }
    }

    public function products($id){
        $tag = Tag::findOrFail($id);

        if($tag){
            $tag_products = $tag->products;

            $products = [];

            foreach($tag_products as $product) {
                $products[] = $product->product;
            }

            return view('tags.products', ['products' => $products, 'tag' => $tag]);
        } else {
            $tag = '';
            return view('tags.products', ['products' => $products, 'tag' => $tag]);
        }
    }

    public function deleteProductTag($product_id, $tag_id){

        $product_tag = ProductTag::where('product_id', '=', $product_id)->where('tag_id', '=', $tag_id);

        if($product_tag) {
            $product_tag->delete();
            return redirect()->back()->with('msg', 'Produto excluído da tag com sucesso');
        } else {
            return response(['message' => 'Produto não encontrado nesta tag'], 404);
        }

     }
}
