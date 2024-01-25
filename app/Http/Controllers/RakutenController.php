<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\comparison;
use RakutenRws_Client;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class RakutenController extends Controller
{

    //ログインユーザのid取得のために必要
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    //ページネーションでの取得を実現
    public function get_rakuten_items(Request $request , $page)
    {
        $userID = Auth::id();
        $client = new RakutenRws_Client();
        $rakutenAppId = env('RAKUTEN_APPLICATION_ID');
        $client->setApplicationId($rakutenAppId);
        $currentPage  =$page;
        $totalPages = 10; 
        $keyword = $request->input('keyword', 'きかんしゃトーマス'); // デフォルトは 'きかんしゃトーマス'
        $response = $client->execute('IchibaItemSearch', ['keyword' => $keyword, 'page' => $page]);
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
            // $sortKey = $request->input('sort_key', 'price'); // リクエストからソートのキーを取得
            // $sortOrder = $request->input('sort_order', 'asc'); // リクエストからソートの順序を取得
            // $items = collect($items)->sortBy($sortKey, SORT_NATURAL, $sortOrder === 'desc')->values()->all();
            return view('comparisons.rakuten',  compact('items','userID','currentPage','totalPages','request'));
        }
    }
//1回のページ訪問で複数のAPIを実行している
    // public function searchItems(Request $request)
    // {
    //     $client = new RakutenRws_Client();
    //     $rakutenAppId = env('RAKUTEN_APPLICATION_ID');
    //     $client->setApplicationId($rakutenAppId);
    //     $keyword = $request->input('keyword', 'きかんしゃトーマス'); // デフォルトは 'きかんしゃトーマス'
    //     $genreId = $request->input('genreId', '0'); // デフォルトは '全ジャンル'
    //     $page =4;
    //     $response = $client->execute('IchibaItemSearch', ['keyword' => $keyword,'page'=>$page]); 
    //     // $response = $client->execute('IchibaItemSearch', ['keyword' => $keyword, 'genreId' => $genreId]); //ジャンル追加版
        
    //     if (!$response->isOk()) {
    //         return 'Error:' . $response->getMessage();
    //     } else {
    //         $items = [];
    //         foreach ($response as $key => $rakutenItem) {

    //             $items[$key]['title'] = $rakutenItem['itemName'];
    //             $items[$key]['price'] = $rakutenItem['itemPrice'];
    //             $items[$key]['url'] = $rakutenItem['itemUrl'];
    //             $items[$key]['shop'] = $rakutenItem['shopName'];
    //             if ($rakutenItem['imageFlag']) {
    //                 $imgSrc = $rakutenItem['mediumImageUrls'][0]['imageUrl'];
    //                 $items[$key]['img'] = preg_replace('/^http:/', 'https:', $imgSrc);
    //             }
    //         }
    //     }
    //         //ソート機能のため、以下のみ追加
    //         $sortKey = $request->input('sort_key', 'price'); // リクエストからソートのキーを取得
    //         $sortOrder = $request->input('sort_order', 'asc'); // リクエストからソートの順序を取得

    //         $items = collect($items)->sortBy($sortKey, SORT_NATURAL, $sortOrder === 'desc')->values()->all();
    //         return view('comparisons.rakuten', compact('items'));
    //         //ここまで
    //         // return view('comparisons.rakuten', ['items' => $item]);
    //     }

        //APIを複数取得できたパターン
    public function searchItems(Request $request)
    {

        $userID = Auth::id();
        $client = new RakutenRws_Client();
        $rakutenAppId = env('RAKUTEN_APPLICATION_ID');
        $client->setApplicationId($rakutenAppId);
        $keyword = $request->input('keyword', 'きかんしゃトーマス'); // デフォルトは 'きかんしゃトーマス'
        $genreId = $request->input('genreId', '0'); // デフォルトは '全ジャンル'
    
        $items = []; // 商品情報のリストを初期化
    
        for ($page = 1; $page <= 5; $page++){
            $response = $client->execute('IchibaItemSearch', ['keyword' => $keyword, 'page' => $page]);
            sleep(1);
            if (!$response->isOk()) {
                return 'Error:' . $response->getMessage();
            }


          
    
            $itemKey = ['itemName', 'itemPrice', 'itemCaption', 'shopName', 'shopUrl', 'itemUrl'];
    
            foreach ($response as $key => $rakutenItem) {
                $tmpItem = [];
    
                // 各商品情報を取得
                $tmpItem['title'] = $rakutenItem['itemName'];
                $tmpItem['price'] = $rakutenItem['itemPrice'];
                $tmpItem['url'] = $rakutenItem['itemUrl'];
                $tmpItem['shop'] = $rakutenItem['shopName'];
    
                if ($rakutenItem['imageFlag']) {
                    $imgSrc = $rakutenItem['mediumImageUrls'][0]['imageUrl'];
                    $tmpItem['img'] = preg_replace('/^http:/', 'https:', $imgSrc);
                }
    
                // 必要な項目だけを一時的な商品情報に格納
                foreach ($itemKey as $itemField) {
                    $tmpItem[$itemField] = $rakutenItem[$itemField];
                }
    
                // 一時的な商品情報をリストに追加
                $items[] = $tmpItem;

            }
        }
        // ソート機能のため、以下のみ追加
        $sortKey = $request->input('sort_key', 'price');// リクエストからソートのキーを取得
        $sortOrder = $request->input('sort_order', 'asc'); // リクエストからソートの順序を取得
        $items = collect($items)->sortBy($sortKey, SORT_NATURAL, $sortOrder === 'desc')->values()->all();
    
        return view('comparisons.rakuten', compact('items','userID'));
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

    //一覧表示
    public function index()
    {
        $user = Auth::id();
        $name = Auth::user()->name;
        $comparisons = Comparison::where('userid', $user)->get(); //guestsテーブル(複数形)に登録されているデータ項目を、モデルGuest.php(単数形)を通じて、全て取得。
        // dd($comparisons); //変数guestの中身確認
        return view('comparisons.index', ['comparisons' => $comparisons],compact('name')); //①guest.blade.phpを呼び出す、⓶bladeの変数guestsに、$guestsの中身(Guest::all();)を渡す
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

    //楽天のトップページを表示する
    public function RakutenTop()
    {
        $page=1;
        return view('comparisons.rakuten-top',compact('page'));
}

}
