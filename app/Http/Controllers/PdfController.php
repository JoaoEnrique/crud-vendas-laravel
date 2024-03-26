<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use PDF;

class PdfController extends Controller
{
    public function createSalePdf()
    {
        
        $sales = Sale::select('sales.*', 'users.name as seller_name', 'customers.name as client_name', DB::raw('COUNT(installments.id) as total_parcelas'))
            ->join('users', 'sales.id_seller', '=', 'users.id')
            ->join('customers', 'sales.id_client', '=', 'customers.id')
            ->join('installments', 'sales.id', '=', 'installments.id_sale')
            ->groupBy('sales.id', 'sales.id_seller', 'sales.id_client', 'sales.total', 'sales.payment_method', 'sales.created_at','sales.updated_at')
            ->groupBy('users.name', 'customers.name')
            ->get();
            
        $pdf = PDF::loadView('pdf', compact('sales'));

        return $pdf->download('sales.pdf');
    }
}
