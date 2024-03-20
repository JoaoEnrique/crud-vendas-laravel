<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Venda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (!empty(session('danger')))   
                    <div class="bg-red-100 border mb-4 border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Erro no cadastro!</strong>
                        <span class="block sm:inline">{{session('danger')}}
                      </div>
                    @endif

                    <form method="POST" action="{{ route('sale.create') }}">
                        @csrf

                        <h1 class="font-semibold text-xl mb-4 text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Cadastrar Cliente') }}
                        </h1>
                        <div class="grid md:grid-cols-2 md:gap-6">

                            <div class="relative z-0 w-full group ml-3 mt-4">
                                <x-input-label for="id_client" :value="__('Cliente')" />
                                <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full select-client" name="id_client" id="id_client" required value>
                                    @foreach($customers as $client)
                                        <option @if($client->id == $sale->id_client) selected  @endif value="{{ $client->id }}">{{ 'ID: ' . $client->id . ' e Nome: ' . $client->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('id_client')" class="mt-2" />
                            </div>

                            
                            <div class="relative z-0 w-full group ml-3 mt-4">
                            <x-input-label for="method" :value="__('Método de pagamento')" />
                            <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" name="method" id="method" required value>
                                <option @if('Cartão' == $sale->payment_method) selected  @endif value="Cartão">Cartão</option>
                                <option @if('Boleto' == $sale->payment_method) selected  @endif value="Boleto">Boleto</option>
                                <option @if('Dinheiro' == $sale->payment_method) selected  @endif value="Dinheiro">Dinheiro</option>
                            </select>
                            <x-input-error :messages="$errors->get('method')" class="mt-2" />
                        </div>

                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full group ml-3 mt-4" id="clientData">
                                <p>Nome: {{$customers[0]->name}}</p>
                                <p>Email: {{$customers[0]->email}}</p>
                                <p>CPF / CNPJ: {{$customers[0]['cpf/cnpj']}}</p>
                                <p>RG: {{$customers[0]->rg}}</p>
                                <p>Cidade: {{$customers[0]->city}}</p>
                                <p>Telefone: {{$customers[0]->phone}}</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="py-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h1 class="font-semibold text-xl mb-4 text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Cadastrar Produto') }}
                            </h1>

                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full group ml-3 mt-4">
                                    <x-input-label for="id_product" :value="__('Produto')" />
                                    <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" name="id_product" id="id_product" required>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('id_product')" class="mt-2" />
                                </div>
                                <div class="relative z-0 w-full group ml-3 mt-4">                                
                                    <div class="block button-add-product mt-1 w-full mt-4">
                                        <x-secondary-button class="mt-4">
                                            {{ __('Adicionar') }}
                                        </x-secondary-button>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="grid grid-cols-1 md:gap-6" id="productList">
                                <!-- Esta div será preenchida com os dados dos produtos adicionados -->
                            </div>
                        </div>
                        
                    </div>
                </div>


                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h1 class="font-semibold text-xl mb-4 text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Parcelas') }}
                            </h1>

                        <div class="relative z-0 w-full group ml-3 mt-4">
                            <h1 class="font-semibold text-xl mb-4 text-gray-800 dark:text-gray-200 leading-tight">
                                <span class="total"></span>                            
                                <input class="input-total hidden" type="text" id="total" name="total"/>

                            </h1>
                        </div>

                        <div class="grid md:grid-cols-3 md:gap-6 " id="installmentList">
                            <!-- Esta div será preenchida com os dados das parcelas adicionadas -->
                        </div>
                        
                        <div class="relative z-0 button-add-installment w-full group ml-3 mt-4">
                            <x-secondary-button class="mt-4 w-full">
                                {{ __('Adicionar') }}
                            </x-secondary-button>
                        </div>
                        
                        <div class="block mt-1 w-full mt-4 button-submit-sales">
                            <x-primary-button disabled class="mt-4 button-send-sale">
                                {{ __('Cadastrar') }}
                            </x-primary-button>
                        </div>
                        
                        </div>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>