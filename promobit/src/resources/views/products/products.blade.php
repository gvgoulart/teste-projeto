<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produtos') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if(isset($products) && count($products) == 0)
                    <div>
                        <h1>Não há nenhum producto!</h1>
                    </div>
                @endif
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($products as $product) 
                    <tr>
                    <th scope="row">{{$product->name}}</th>
                    <td>
                        <a type="button" class="btn btn-danger" href="{{ route('product_delete', ['id' => $product->id]) }}">Deletar</a>
                    </td>
                    <td>
                        <a
                            type="button"
                            class="btn btn-info"
                            href="{{ route('product_edit_form', ['id' => $product->id]) }}">
                            Editar
                        </a>
                    </td>
                    <td>
                        <a
                            type="button"
                            class="btn btn-info"
                            href="{{ route('product_tags', ['id' => $product->id]) }}">
                            Tags
                        </a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>

                <td>
                    <a type="button" class="btn btn-success" href="{{ route('product_createForm') }}">Criar Produto</a>
                </td>
            </table>
            </div>
            @if(session('msg'))
                <div class="alert alert-success" role="alert">
                    {{session('msg')}}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
