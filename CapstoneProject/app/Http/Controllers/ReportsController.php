<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ReportsController extends Controller
{
    public function ViewInvoice() {

        $pdf = PDF::loadview('pdf.invoice')->setPaper('letter', 'landscape');
        return $pdf->stream();

    }
}
