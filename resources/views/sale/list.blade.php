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
                            <table id="datatables" class="min-w-full">
                                <thead class="border-b">
                                    <tr>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Vendedor</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Cliente</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Total</th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                    <tr class="border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sale->seller_name }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $sale->client_name }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">R$ {{ $sale->total }}</td>
                                        <td class="text-sm text-gray-900 font-light px-7 py-4 whitespace-nowrap" style="min-width: 180px">

                                            <a href="/sale/update/{{$sale->id}}" class="mr-2 text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded">
                                                {{ __('Editar') }}
                                            </a>

                                            <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion{{$sale->id}}')">
                                                {{ __('Apagar') }}
                                            </x-danger-button>

                                            <x-modal name="confirm-user-deletion{{$sale->id}}" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                                <form method="post" action="{{ route('sale.delete', $sale->id) }}" class="p-6">
                                                    @csrf
                                                    @method('delete')

                                                    <h2 class="text-lg font-medium text-gray-900">
                                                        {{ __('Tem certeza que deseja apagar este salee?') }}
                                                    </h2>

                                                    <p class="mt-1 text-sm text-gray-600">
                                                        {{ __('id da venda: ' . $sale->name) }}
                                                    </p>

                                                    <div class="mt-6 flex justify-end">
                                                        <x-secondary-button class="mr-2 " x-on:click="$dispatch('close')">
                                                            {{ __('Cancelar') }}
                                                        </x-secondary-button>

                                                        <x-danger-button class="ms-3">
                                                            {{ __('Apagar') }}
                                                        </x-danger-button>
                                                    </div>
                                                </form>
                                            </x-modal>
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