<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TesteController extends Controller
{
    public function teste() {
        $products = [
            'preto-PP',
            'preto-M',
            'preto-G',
            'preto-GG', 
            'preto-GG',
            'branco-PP',
            'branco-G',
            'vermelho-M',
            'azul-P',
            'azul-XG',
            'azul-XG',
            'azul-XG', 
        ];

        $brands = ['preto', 'branco', 'vermelho', 'azul'];

        $options = ['PP', 'P', 'M', 'G', 'GG', 'XG'];

        foreach($products as $product) {
            $array[] = explode("-",$product);
        }

        $brands_separadas = [];

        foreach($array as $arr) {
            if(in_array($arr[0], $brands)) {
                if(!in_array($arr[0], $brands_separadas)) {
                    $brands_separadas[] = $arr[0];
                }
            }
        }

        $testinho = [];

        foreach($brands_separadas as $brand) {
            foreach($array as $arr) {
                if(in_array($arr[1], $options) && $arr[0] == $brand) {
                    $testinho[] = $arr[1];
                    $teste[$brand] = array_count_values($testinho);
                }
            }
            unset($testinho);
        }

        return $teste;
    }
}error_log 404 ´{pintinhofofo} return unregister_tick_function
testinho
