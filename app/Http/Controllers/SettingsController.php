<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SettingsController extends Controller
{
    
    public function store(Request $request)
    {
        if($request->has('ur_date')){
            $ur_date = $request->input('ur_date');
            DB::table('employees')
            ->update(['cutoff_date' => $ur_date]);
            $request->session()->flash('message', 'Upload restriction date saved successfully!');
            return response('', 200)
                  ->header('Content-Type', 'text/plain');
        }else{
            $request->session()->flash('message', 'Upload restriction date is missing!');
            return back()->withInput();
        }
        //Todo:open file for writing ur-date.txt
    }

    public function mstore(Request $request)
    {
        if($request->has('ur_date')){
            $ur_date = $request->input('ur_date');
            DB::table('employees')
            ->update(['cutoff_date' => $ur_date]);
            return response('', 200)
                  ->header('Content-Type', 'text/plain');
        }else{
            return response(['missing_parameter' => 'ur_date'], 400)
                  ->header('Content-Type', 'text/plain');
        }
        //Todo:open file for writing ur-date.txt
    }

}
