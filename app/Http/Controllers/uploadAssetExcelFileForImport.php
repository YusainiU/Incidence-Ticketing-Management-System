<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\assetImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customer;

class uploadAssetExcelFileForImport extends Controller
{

    public function import(Request $request)
    {
        if($request->customer) {
            $c = Customer::find($request->customer);
            Excel::import(new assetImport($c), request()->file('assetFile'));
            return back()->with('success','File imported successfully');
        }else{
            return back()->with('failed','No customer specified');
        }
    }    
}
