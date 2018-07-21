<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//注意这里引用了BaomingAPI
use App\BaomingAPI\BaomingAPI;

class BaomingController extends Controller
{
    public function handle(Request $request){
        $baoming = new BaomingAPI();
        return response($baoming->handle($request->all()));
    }

    public function showTable(){
        $file_name = '报名信息表';
        $baoming = new BaomingAPI();
        $baoming->exportExcel('360baomings',$file_name);
        return response()->download(realpath(base_path('public')).$file_name,$file_name);
    }
}
