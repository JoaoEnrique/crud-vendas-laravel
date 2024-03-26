<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listar Produto') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (!empty(session('sucess')))   
                    <div class="bg-green-100 border mb-4 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">{{session('sucess')}}</strong>
                        {{-- <span class="block sm:inline"></span> --}}
                      </div>
                    @endif

                    <div class="overflow-y-auto max-h-96">
                        @if(!empty($products[0]))
                            <table class="min-w-full" id="datatables">
                                <thead class="border-b">
                                    <tr>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Nome</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Preço</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Criado em:</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Atualizado em:</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr class="border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ 'R$ '.number_format($product->price, 2, ',', '.') }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $product->created_at }}</td>
                                        @if($product->created_at != $product->updated_at)
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $product->updated_at }}</td>
                                        @else
                                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">Não foi editado</td>
                                        @endif

                                        <td class="text-sm text-gray-900 font-light px-7 py-4 whitespace-nowrap" style="min-width: 180px">
                                            <form method="post" action="{{ route('product.delete', $product->id) }}" class="p-6">
                                                <a href="/product/update/{{$product->id}}" class="mr-2 text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded">
                                                    {{ __('Editar') }}
                                                </a>

                                                @csrf
                                                @method('delete')

                                                    <x-danger-button class="ms-3">
                                                        {{ __('Apagar') }}
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="px-8 text-center">
                                <p class="px-4 py-2 md:text-2xl text-2xl">Nenhum produto cadastrado.</p>
                            </div> 
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>