<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customers;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Installments;

class SaleController extends Controller
{
    public function create(){
        $customers = Customers::all();
        $products = Product::all();

        if(!count($customers)){
            return redirect()->route('client.create');
        }

        return view('sale.create', ['customers' => $customers, 'products' => $products]);
    }

    public function store(Request $request){
        $products = json_decode($request->input('produtos'), true);
        $installments = json_decode($request->input('installments'), true);

        $sale = Sale::create([
            'id_seller' => auth()->user()->id,
            'id_client' => $request->id_client,
            'payment_method' => $request->method,
            'total' => $request->total,
        ]);

        if (!empty($products)) {
            foreach ($products as $product) {
                if(!$product['id_product'] || !$product['quantity'] || !$product['price'])
                    return back()->with('danger', 'Preencha todos os campos dos produtos')->withInput();

                $id_product = $product['id_product'];
                $quantity = $product['quantity'];
                $price = $product['price'];

                $sale_item = SaleItem::create([
                    'id_sale' => $sale->id,
                    'id_product' => $id_product,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }
        }else{
            
            return back()->with('danger', 'Preencha todos campos dos produtos')->withInput();
        }

        if (!empty($installments)) {
            foreach ($installments as $installment) {
                if(!$installment['value'] || !$installment['invoice_date'])
                    return back()->with('danger', 'Preencha todos os campo das parcelas')->withInput();

                $invoice_date = $installment['invoice_date'];
                $value = $installment['value'];

                $sale_item = Installments::create([
                    'id_sale' => $sale->id,
                    'invoice_date' => $invoice_date,
                    'value' => $value,
                    'num' => count($installments),
                ]);
            }
        }else{
            return back()->with('danger', 'Preencha todos das parcelas')->withInput();
        }


        return redirect()->route('sale.list')->with('sucess', 'Venda cadastrada');

    }

    public function list(){
        $sales = Sale::select('sales.*', 'users.name as seller_name', 'customers.name as client_name')
            ->join('users', 'sales.id_seller', '=', 'users.id')
            ->join('customers', 'sales.id_client', '=', 'customers.id')
            ->get();

        return view('sale.list', ['sales' => $sales]);
    }

    public function edit($id){
        $sale  = Sale::find($id);
        $customers = Customers::all();
        $products = Product::all();


        if($sale)
            return view('sale.edit', ['sale' => $sale, 'customers' => $customers, 'products' => $products]);

        
        return view('sale.edit', ['sale' => 0, 'customers' => $customers, 'products' => $products]);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|min:3|string|max:255',
            'price' => 'required',
        ]);

        $dados = $request->only(['name', 'price']);

        $sale = Product::findOrFail($request->id);

        $sale->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        if($sale)
            return redirect()->route('sale.list')->with('sucess', 'Venda atualizado');
        
        return back()->with('danger', 'Não foi possível atualizar venda, tente novamente mais tarde!');
    }

    public function delete(Request $request, $id){
        $sale = Product::find($id)->delete();

        if($sale)
            return redirect()->route('sale.list')->with('sucess', 'Venda excluido');

        return back()->with('danger', 'Não foi possível excluit venda, tente novamente mais tarde!');
    }
}
