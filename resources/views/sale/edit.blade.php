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


                    <form method="POST" class="form-send-sale" action="{{ route('sale.update') }}">
                        @csrf
                        <input type="text" class="hidden" value="{{$sale->id}}" name="sale_id" id="sale_id" >

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
                                @foreach($customers as $client)
                                    @if($client->id == $sale->id_client)
                                        <p>Nome: {{$client->name}}</p>
                                        <p>Email: {{$client->email}}</p>
                                        <p>CPF / CNPJ: {{$client['cpf/cnpj']}}</p>
                                        <p>RG: {{$client->rg}}</p>
                                        <p>Cidade: {{$client->city}}</p>
                                        <p>Telefone: {{$client->phone}}</p>
                                    @endif
                                @endforeach
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
                            @php
                                $code = 0;
                            @endphp
                            <div class="grid grid-cols-1 md:gap-6" id="productList">
                                @foreach($products_selected as $product_selected)
                                    @php
                                        $subtotal = $product_selected->price * $product_selected->quantity;
                                        $code++;
                                    @endphp
                                    <div data-code='{{$code}}' id="product-{{$code}}" class="grid grid-cols-5 md:gap-6">
                                        <div class="relative z-0 w-full group ml-3 mt-4">
                                            <label class="block font-medium text-sm text-gray-700" for="produto">Produto</label>
                                            <input class="hidden" type="text" name="id_product[]" value="{{$product_selected->id}}" />
                                            <input min="1" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="text" name="produto[]" value="{{$product_selected->name}}" />
                                        </div>
                                        <div class="relative z-0 w-full group ml-3 mt-4">
                                            <label class="block font-medium text-sm text-gray-700" for="quantity">Quantidade</label>
                                            <input min="1" data-code="{{$code}}" required class="quantity-{{$code}} calc-subtotal border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" name="quantity[]" value='{{$product_selected->quantity}}' />
                                        </div>
                                        <div class="relative z-0 w-full group ml-3 mt-4">
                                            <label class="block font-medium text-sm text-gray-700" for="price">Preço Unitário</label>
                                            <input min="1" data-code="{{$code}}" required class="price-{{$code}} calc-subtotal border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" name="price[]" value="{{$product_selected->price}}" />
                                        </div>
                                        <div class="relative z-0 w-full group ml-3 mt-4">
                                            <label class="block font-medium text-sm text-gray-700" for="subtotal">Subtotal</label>
                                            <input disabled min="1" onlyread required class="subtotal-{{$code}} border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" name="subtotal[]" value='{{$subtotal}}'/>
                                        </div>
                                        <div class="relative z-0 w-full group ml-3 mt-4">
                                            <div data-product="{{$code}}" class="text-center cursor-pointer bg-red-600 button-remove-product rounded-md shadow-sm mt-6 flex justify-center align-super text-white" style="height: 40px; align-items: center;">Remover</div>            
                                        </div>
                                    </div>
                                @endforeach
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
                                <span class="total">Total: R$ {{$sale->total}}</span>                     
                                <input class="input-total hidden" type="text" id="total" name="total" value="{{$sale->total}}"/>
                            </h1>
                        </div>

                        @php
                            $codeInstallment = 0;
                        @endphp
                        <div class="grid md:grid-cols-1 md:gap-6 " id="installmentList">
                            @foreach($installments as $installment)
                                <div data-code='installment-{{$codeInstallment}}' id="installment-{{$codeInstallment}}"  class="grid grid-cols-3 md:gap-6">
                                    <div class="installment-{{$codeInstallment}} relative z-0 w-full group ml-3 mt-4">
                                        <label class="block font-medium text-sm text-gray-700">Valor</label>
                                        <input required id="value" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" type="number" value="{{$installment->value}}" name="value[]" />
                                    </div>
                    
                                    <div class="installment-{{$codeInstallment}} relative z-0 w-full group ml-3 mt-4">
                                        <label class="block font-medium text-sm text-gray-700">Data de Vencimento</label>
                                        <input required type="date" id="invoice_date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"  value="{{$installment->invoice_date}}" name="invoice_date[]" />
                                    </div>
                                    <div class="installment-{{$codeInstallment}} relative z-0 w-full group ml-3 mt-4">
                                        <div required data-installment="{{$codeInstallment}}" class="text-center cursor-pointer bg-red-600 button-remove-installment rounded-md shadow-sm mt-6 flex justify-center align-super text-white" style="height: 40px; align-items: center;">Remover</div>            
                                    </div>
                                </div>
                                @endforeach
                        </div>
                        
                        <div class="relative z-0 button-add-installment w-full group ml-3 mt-4">
                            <x-secondary-button class="mt-4 w-full">
                                {{ __('Adicionar') }}
                            </x-secondary-button>
                        </div>
                        

                        <div id="errors" class="mt-3">
    
                        </div>

                        <div class="block mt-1 w-full mt-4 button-submit-sales">
                            <x-primary-button class="mt-4 button-send-sale">
                                {{ __('Editar') }}
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