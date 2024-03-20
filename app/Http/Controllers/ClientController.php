<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\SaleItem;
use App\Models\Installments;
use App\Models\Sale;

class ClientController extends Controller
{
    public function create(){
        return view('client.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|min:3|string|max:255',
            'cpf/cnpj' => 'required|min:9|string|max:255',
            'rg' => 'required|min:9|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255'
        ]);

        $dados = $request->only(['name', 'cpf/cnpj', 'rg', 'city', 'phone', 'email']);
        $client = Customers::create($dados);

        if($client)
            return redirect()->route('client.list')->with('sucess', 'Cliente cadastrado');
        
        return back()->with('danger', 'Não foi possível cadastrar cliente, tente novamente mais tarde!');
    }

    public function list(){
        $customers = Customers::all();
        return view('client.list', ['customers' => $customers]);
    }

    public function edit($id){
        $client  = Customers::find($id);

        if($client)
            return view('client.edit', ['client' => $client]);

        
        return view('client.edit', ['client' => 0]);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|min:3|string|max:255',
            'cpf/cnpj' => 'required|min:9|string|max:255',
            'rg' => 'required|min:9|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255'
        ]);

        $dados = $request->only(['name', 'cpf/cnpj', 'rg', 'city', 'phone', 'email']);

        $client = Customers::findOrFail($request->id);

        $client->update([
            'name' => $request->name,
            'cpf/cnpj' => $request['cpf/cnpj'],
            'rg' => $request->rg,
            'city' => $request->city,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        if($client)
            return redirect()->route('client.list')->with('sucess', 'Cliente atualizado');
        
        return back()->with('danger', 'Não foi possível atualizar cliente, tente novamente mais tarde!');
    }

    public function delete(Request $request, $id){
        $sales = Sale::where('id_client', $id)->get();

        foreach($sales as $sale){
            $sale_itens = SaleItem::where('id_sale', $sale->id)->delete();
            $installments = Installments::where('id_sale', $sale->id)->delete();
            $sale->delete();
        }

        $client = Customers::find($id)->delete();

        if($client)
            return redirect()->route('client.list')->with('sucess', 'Cliente excluido');

        return back()->with('danger', 'Não foi possível excluit cliente, tente novamente mais tarde!');
    }

    public function getById($id)
    {
        $user = Customers::find($id);
        return response()->json($user);
    }
}
