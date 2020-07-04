<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JDD\Api\Http\Controllers\ApiController;

class ExcelController extends ApiController
{
    public function excel(Request $request, ...$route)
    {
        $data = $this->index($request, ...$route)->getData();
        $data = json_decode(json_encode($data), true);
        $api = url($request->input('api'));
        //$data = json_decode(file_get_contents($api), true);
        dd($data);
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        //header("Content-Disposition: attachment;filename=\"filename.xlsx\"");
        header("Cache-Control: max-age=0");
        return view('excel', compact('data'));
    }
}
