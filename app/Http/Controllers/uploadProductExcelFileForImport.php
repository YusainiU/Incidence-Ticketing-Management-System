<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\productImport;
use Maatwebsite\Excel\Facades\Excel;


class uploadProductExcelFileForImport extends Controller
{

    public function import(Request $request)
    {
        Excel::import(new productImport(Auth()->user()), request()->file('productFile'));
        return back()->with('success','File imported successfully');
    }

}
