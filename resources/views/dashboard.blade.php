<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 flex max-w-7xl mx-auto flex-row flex-wrap justify-center">
        <div class="basis-1/4 m-4" onclick="window.location.href='/client'" style="cursor: pointer">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Listar Cliente") }}
                </div>
            </div>
        </div>
        <div class="basis-1/4 m-4" onclick="window.location.href='/client/create'" style="cursor: pointer">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Cadastrar Cliente") }}
                </div>
            </div>
        </div>
        <div class="basis-1/4 m-4" onclick="window.location.href='/product'" style="cursor: pointer">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Listar Produtos") }}
                </div>
            </div>
        </div> 
        <div class="basis-1/4 m-4" onclick="window.location.href='/product/create'" style="cursor: pointer">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Cadastrar Produtos") }}
                </div>
            </div>
        </div>
        <div class="basis-1/4 m-4" onclick="window.location.href='/sale'" style="cursor: pointer">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Listar Vendas") }}
                </div>
            </div>
        </div>
        <div class="basis-1/4 m-4" onclick="window.location.href='/sale/create'" style="cursor: pointer">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Cadastrar Vendas") }}
                </div>
            </div>
        </div>
      </div>
    
</x-app-layout>
