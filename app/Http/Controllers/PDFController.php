<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;

use App\Models\Maintenance;
use App\Models\Incentives;

class PDFController extends Controller
{
    public function generatePDFReport(Request $request)
    {
        //dd($request);
        $mechanicName = $request->input('mechanic_name');
        $phone = $request->input('phone');
        $address = $request->input('address');

        $cars = json_decode($request->input('cars_data'), true);
        $products = json_decode($request->input('products_data'), true);
        $dateGenerated = now()->setTimezone('Asia/Manila')->format('F j, Y g:i A');
        //dd($cars);

        $mechanicId = $request->input('mechanic_id');;
        //dd($mechanicId);

        if (!$mechanicId) {
            return redirect()->back()->withErrors(['Mechanic ID not found.']);
        }

        $data = compact('mechanicName', 'phone', 'address', 'cars', 'products', 'dateGenerated');

        $pdf = PDF::loadView('reports.mechanicReports', $data);
        
        $safeFileName = preg_replace('/[^A-Za-z0-9\-]/', '_', $mechanicName);
        $formattedDate = now()->setTimezone('Asia/Manila')->format('F j, Y');
        $filename = "{$safeFileName}_Report_{$formattedDate}.pdf";

        Maintenance::where('mechanic_id', $mechanicId)->delete();
        Incentives::where('mechanic_id', $mechanicId)->delete();

        return $pdf->download($filename);
    }
}
