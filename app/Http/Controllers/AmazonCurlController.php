<?php

namespace App\Http\Controllers;

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AmazonCurlController extends Controller
{
    public function searchAmazonProducts(Request $request)
    {
        
        // session_start();
        $name = $request->input('name');;
        include_once base_path('amazon.php');
        $amazonData = $response;

        //json形式の文字列をPHPの配列に変換
        $apiData = json_decode($amazonData, true)['SearchResult']['Items'];
        // $apiitems=$apiData['Items'];
        // $amazonData = $_SESSION['api_data'];
        return view('comparisons.amazon',['items' => $apiData]);
    }

    public function AmazonTop()
    {
        return view('comparisons.amazon-top');
}

}