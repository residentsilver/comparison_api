<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\comparison;
use RakutenRws_Client;
use Carbon\Carbon;

class ComparisonController extends Controller
{


public function index(Request $request){
    //DBとつながずに練習として表示させる。
    // $book = [
    //     'id' =>1,
    //     'title' =>'初めてのJavaScript',
    //     'price' =>2000
    // ];
    // return $book;


    //DBから取得した複数個のデータが$itemsに入っている場合
    $items = Comparison::all();
    return $items ->toArray();//配列として渡している
}


}