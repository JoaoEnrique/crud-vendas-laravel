<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use PDF;

class PdfController extends Controller
{
    public function createSalePdf()
    {
        $sales = Sale::select('sales.*', 'users.name as seller_name', 'customers.name as client_name')
            ->join('users', 'sales.id_seller', '=', 'users.id')
            ->join('customers', 'sales.id_client', '=', 'customers.id')
            ->get();
            
        $pdf = PDF::loadView('pdf', compact('sales'));

        return $pdf->download('sales.pdf');
    }
}
