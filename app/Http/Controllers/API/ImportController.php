<?php
// app/Http/Controllers/API/ImportController.php

namespace App\Http\Controllers\API;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        Excel::import(new UsersImport(), $file);

        return response()->json(['message' => 'Import completed successfully']);
    }
}
