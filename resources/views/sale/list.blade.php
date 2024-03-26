<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listar Venda') }}
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
                        @if(!empty($sales[0]))
                        <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                            <div class="relative z-0 w-full group ml-3 mt-4">
                            <a href="/creare-sale-pdf" class="mr-2 text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded">GERAR PDF</a>
                            </div>
                        </div>

                            <table id="datatables" class="min-w-full">
                                <thead class="border-b">
                                    <tr>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Vendedor</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Cliente</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Total</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Total de Parcelas</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                    <tr class="border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sale->seller_name }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $sale->client_name }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">R$ {{ $sale->total }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sale->total_parcelas }}</td>
                                        <td class="text-sm text-gray-900 font-light px-7 py-4 whitespace-nowrap" style="min-width: 180px">

                                            <form method="post" action="{{ route('sale.delete', $sale->id) }}" class="p-6">
                                                <a href="/sale/update/{{$sale->id}}" class="mr-2 text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded">
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
                                <p class="px-4 py-2 md:text-2xl text-2xl">Nenhuma venda cadastrada.</p>
                            </div> 
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>