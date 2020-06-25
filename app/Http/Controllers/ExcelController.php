<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function download(Request $request)
    {
        $api = $request->input('api');
        $data = json_decode(file_get_contents($api), true);
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=\"filename.xlsx\"");
        header("Cache-Control: max-age=0");
        return view('excel', compact('data'));
    }
}
