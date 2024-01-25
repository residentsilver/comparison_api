<?php

namespace App\Http\Controllers;

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\comparison;
class AmazonCurlController extends Controller
{
       //ログインユーザのid取得のために必要
       protected $auth;

       public function __construct(Auth $auth)
       {
           $this->auth = $auth;
       }

    public function searchAmazonProducts(Request $request)
    {
        
        // session_start();
        $userID = Auth::id();
        $name = $request->input('name');;
        include_once base_path('amazon.php');
        $amazonData = $response;

        //json形式の文字列をPHPの配列に変換
        $apiData = json_decode($amazonData, true)['SearchResult']['Items'];
        // $apiitems=$apiData['Items'];
        // $amazonData = $_SESSION['api_data'];
        return view('comparisons.amazon',['items' => $apiData],compact('userID'));
    }

    public function AmazonTop()
    {
        return view('comparisons.amazon-top');
}

    //追加処理 nameカラムが一致する場合更新
    public function save(Request $request)
    {
        // $comparison = new comparison();
        $requestData = $request->all();
        $existingComparison = Comparison::where('name', $requestData['name'])->first();

        if ($existingComparison) {
            $existingComparison->update($requestData);
        } else {
            Comparison::create($requestData);
        }
        return redirect()->back();
    }


}