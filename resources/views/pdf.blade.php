
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0.3/dist/tailwind.min.css" rel="stylesheet">

<table id="datatables" class="min-w-full">
    <thead class="border-b">
        <tr>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Vendedor</th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Cliente</th>
            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sales as $sale)
            <tr class="border-b">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sale->seller_name }}</td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $sale->client_name }}</td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">R$ {{ $sale->total }}</td>
            </tr>

        @empty
            <h1>Nenhuma venda cadastrada</h1>
        @endforelse
    </tbody>
</table>