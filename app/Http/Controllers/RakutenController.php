<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\comparison;
use RakutenRws_Client;

class RakutenController extends Controller
{

    public function get_rakuten_items()
    {
      $client = new RakutenRws_Client();
      $rakutenAppId = env('RAKUTEN_APPLICATION_ID');


      $client->setApplicationId($rakutenAppId);

      $response = $client->execute('IchibaItemSearch',array(
          'keyword' => 'きかんしゃトーマス'
      ));

      if(!$response->isOk()){
          return 'Error:'.$response->getMessage();
      } else {
          $items = [];
          foreach($response as $key => $rakutenItem){
              $items[$key]['title'] = $rakutenItem['itemName'];
              $items[$key]['price'] = $rakutenItem['itemPrice'];
              $items[$key]['url'] = $rakutenItem['itemUrl'];

              if($rakutenItem['imageFlag']){
                  $imgSrc = $rakutenItem['mediumImageUrls'][0]['imageUrl'];
                  $items[$key]['img'] = preg_replace('/^http:/','https:',$imgSrc);
              }
          }
          return view('comparisons.top',['items' => $items]);
      }

  }

    public function searchItems(Request $request)
    {
        $client = new RakutenRws_Client();
        $rakutenAppId = env('RAKUTEN_APPLICATION_ID');
        $client->setApplicationId($rakutenAppId);
    
        $keyword = $request->input('keyword', 'きかんしゃトーマス'); // デフォルトは 'きかんしゃトーマス'
    
        $response = $client->execute('IchibaItemSearch', ['keyword' => $keyword]);
    
        // 以下は元のコードと同じです
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
            return view('comparisons.top', ['items' => $items]);
        }
    }
    
    //追加処理
    public function save(Request $request)
    {
        $comparison = new comparison();
        $comparison->fill($request->all())->save();
        return redirect('search'); 
        }

        //一覧表示
        public function index()
        {
            $comparisons = comparison::all(); //guestsテーブル(複数形)に登録されているデータ項目を、モデルGuest.php(単数形)を通じて、全て取得。
            // dd($comparisons); //変数guestの中身確認
            return view('comparisons.index', ['comparisons' => $comparisons]); //①guest.blade.phpを呼び出す、⓶bladeの変数guestsに、$guestsの中身(Guest::all();)を渡す
        }
    

            //削除処理
    public function delete(Comparison $comparison)
    {
        $comparison->delete();
        return redirect('/index');
    }
}