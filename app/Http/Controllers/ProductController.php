<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function create(){
        return view('product.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|min:3|string|max:255',
            'price' => 'required',
        ]);

        $dados = $request->only(['name', 'price']);
        $product = Product::create($dados);

        if($product)
            return redirect()->route('product.list')->with('sucess', 'Produto cadastrado');
        
        return back()->with('danger', 'Não foi possível cadastrar produto, tente novamente mais tarde!');
    }

    public function list(){
        $products = Product::all();
        return view('product.list', ['products' => $products]);
    }

    public function edit($id){
        $product  = Product::find($id);

        if($product)
            return view('product.edit', ['product' => $product]);

        
        return view('product.edit', ['product' => 0]);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|min:3|string|max:255',
            'price' => 'required',
        ]);

        $dados = $request->only(['name', 'price']);

        $product = Product::findOrFail($request->id);

        $product->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        if($product)
            return redirect()->route('product.list')->with('sucess', 'Produto atualizado');
        
        return back()->with('danger', 'Não foi possível atualizar produto, tente novamente mais tarde!');
    }

    public function delete(Request $request, $id){
        $sale_itens = SaleItem::where('id_product', $id)->delete();
        

        $product = Product::find($id)->delete();

        if($product)
            return redirect()->route('product.list')->with('sucess', 'Produto excluido');

        return back()->with('danger', 'Não foi possível excluit produto, tente novamente mais tarde!');
    }

    public function getById($id){
        return Product::find($id);
    }
}
