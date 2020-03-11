<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportImei;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Imei;

class ImportImeiController extends Controller
{
    public function index()
    {
        $imeis = Imei::orderBy('created_at', 'DESC');
        return view('import_excel.index', compact('imeis'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);
        Excel::import(new ImportImei, request()->file('import_file'));
        return back()->with('success', 'IMEIs imported successfully.');
    }
}
