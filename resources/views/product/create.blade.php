<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cadastrar Produto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (!empty(session('danger')))   
                    <div class="bg-red-100 border mb-4 border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Erro no cadastro!</strong>
                        <span class="block sm:inline">{{session('danger')}}</span>
                      </div>
                    @endif

                    <form method="POST" action="{{ route('product.create') }}">
                        @csrf

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full group ml-3 mt-4">
                                <x-input-label for="name" :value="__('Nome')" />
                                <x-text-input id="name" maxlength="255" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus autocomplete="off" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="relative z-0 w-full group ml-3 mt-4">
                                <x-input-label for="price" :value="__('Preço')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" autocomplete="off" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                        </div>
                        <div class="block mt-1 w-full mt-4">
                            <x-primary-button class="mt-4">
                                {{ __('Cadastrar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
