<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\comparison;
use RakutenRws_Client;

class RakutenController extends Controller
{
    // public function get_rakuten_items()
    // {
    //     $client = new RakutenRws_Client();
    //     $rakutenAppId = env('RAKUTEN_APPLICATION_ID');
    //     $client->setApplicationId($rakutenAppId);
    //     $response = $client->execute('IchibaItemSearch', array(
    //         'keyword' => 'きかんしゃトーマス'
    //     ));

    //     if (!$response->isOk()) {
    //         return 'Error:' . $response->getMessage();
    //     } else {
    //         $items = [];
    //         foreach ($response as $key => $rakutenItem) {
    //             $items[$key]['title'] = $rakutenItem['itemName'];
    //             $items[$key]['price'] = $rakutenItem['itemPrice'];
    //             $items[$key]['url'] = $rakutenItem['itemUrl'];
    //             $items[$key]['shop'] = $rakutenItem['shop'];
    //             if ($rakutenItem['imageFlag']) {
    //                 $imgSrc = $rakutenItem['mediumImageUrls'][0]['imageUrl'];
    //                 $items[$key]['img'] = preg_replace('/^http:/', 'https:', $imgSrc);
    //             }
    //         }
    //         view('comparisons.top', ['items' => $items]);
    //     }
    // }

    public function searchItems(Request $request)
    {
        $client = new RakutenRws_Client();
        $rakutenAppId = env('RAKUTEN_APPLICATION_ID');
        $client->setApplicationId($rakutenAppId);

        $keyword = $request->input('keyword', 'きかんしゃトーマス'); // デフォルトは 'きかんしゃトーマス'
        $genreId = $request->input('genreId', '0'); // デフォルトは '全ジャンル'
        $response = $client->execute('IchibaItemSearch', ['keyword' => $keyword]); 
        // $response = $client->execute('IchibaItemSearch', ['keyword' => $keyword, 'genreId' => $genreId]); //ジャンル追加版
        
        if (!$response->isOk()) {
            return 'Error:' . $response->getMessage();
        } else {
            $items = [];
            foreach ($response as $key => $rakutenItem) {
                $items[$key]['title'] = $rakutenItem['itemName'];
                $items[$key]['price'] = $rakutenItem['itemPrice'];
                $items[$key]['url'] = $rakutenItem['itemUrl'];
                $items[$key]['shop'] = $rakutenItem['shopName'];

                if ($rakutenItem['imageFlag']) {
                    $imgSrc = $rakutenItem['mediumImageUrls'][0]['imageUrl'];
                    $items[$key]['img'] = preg_replace('/^http:/', 'https:', $imgSrc);
                }
            }
            //ソート機能のため、以下のみ追加
            $sortKey = $request->input('sort_key', 'price'); // リクエストからソートのキーを取得
            $sortOrder = $request->input('sort_order', 'asc'); // リクエストからソートの順序を取得

            $items = collect($items)->sortBy($sortKey, SORT_NATURAL, $sortOrder === 'desc')->values()->all();

            return view('comparisons.top', compact('items'));
            //ここまで
            // return view('comparisons.top', ['items' => $items]);
        }
    }

    //追加処理　nameカラムが一致する場合更新
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

    //一覧表示
    public function index()
    {
        $comparisons = comparison::all(); //guestsテーブル(複数形)に登録されているデータ項目を、モデルGuest.php(単数形)を通じて、全て取得。
        // dd($comparisons); //変数guestの中身確認
        return view('comparisons.index', ['comparisons' => $comparisons]); //①guest.blade.phpを呼び出す、⓶bladeの変数guestsに、$guestsの中身(Guest::all();)を渡す
    }

    //部分検索
    public function index_search(Request $request)
    {
         $request->input('search'); 
        $item = comparison::find($request->input('search'));
        $items = comparison::where('name', 'like', '%' . $request->input('search') . '%')->get();
        $item = comparison::nameLike($request->input)->get();
        $param = ['input'=>$request->input, 'item'=>$item];
        return view('comparisons.index', ['comparisons' => $items], $param);
    }


    //削除処理
    public function delete(Comparison $comparison)
    {
        $comparison->delete();
        return redirect('/index');
    }
}
