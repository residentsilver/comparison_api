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
    
}
