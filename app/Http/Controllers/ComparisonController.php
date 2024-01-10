<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\comparison;
use RakutenRws_Client;


class ComparisonController extends Controller
{
public function fetchAmazonProduct($asin)
{
    $accessKey = config('ACCESS_KEY_ID');
    $secretKey = config('SEACRET_KEY');
    $associateTag = config('ASSOCIATE_TAG');

    $client = new Client();

    $response = $client->request('GET', 'https://webservices.amazon.com/paapi5/searchitems', [
        'query' => [
            'ASIN' => $asin,
            'PartnerType' => 'Associates',
            'PartnerTag' => $associateTag,
            // Add other required parameters
        ],
        'headers' => [
            'Content-Type' => 'application/json',
            'Host' => 'webservices.amazon.com',
            'Authorization' => 'Bearer ' . $this->generateAmazonSignature($accessKey, $secretKey),
        ],
    ]);

    $result = json_decode($response->getBody(), true);

    return $result;
}


private function generateAmazonSignature($accessKey, $secretKey)
{
    $timestamp = gmdate('Y-m-d\TH:i:s\Z');
    $signString = "GET\nwebservices.amazon.com\n/paapi5/searchitems\n" . $timestamp;

    $signature = base64_encode(hash_hmac('sha256', $signString, $secretKey, true));

    return $signature;
}

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

public function test(Request $request){
    return view('comparisons.top');


}

   public function get_rakuten_items()
      {
        $client = new RakutenRws_Client();

        config('env.RAKUTEN_APPLICATION_ID');

        $client->setApplicationId(RAKUTEN_APPLICATION_ID);

        $response = $client->execute('IchibaItemSearch',array(
            'keyword' => '任意のキーワードを入れてください'
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
            return view('comparison.top',['items' => $items]);//indexファイルへitems変数を送る。;
        }

    }

}