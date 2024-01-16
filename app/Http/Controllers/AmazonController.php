<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\comparison;
use GuzzleHttp\Client;
namespace App\Http\Controllers;
use AmazonProduct;
use App\Http\Controllers\Controller;


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\PartnerType;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsResource;


class AmazonController extends Controller
{
    public function searchAmazonProducts()
    {
        $accessKey = env('AMAZON_ACCESS_KEY');
        $secretKey = env('AMAZON_SECRET_KEY');
        $associateTag = env('AMAZON_ASSOCIATE_TAG');

        // クレデンシャルの設定
        $config = new \Paapi5\DefaultConfiguration();
        $config->setAccessKey($accessKey);
        $config->setSecretKey($secretKey);
        $config->setPartnerTag($associateTag);

        // クライアントの初期化
        $client = new \Paapi5\DefaultAPIClient($config);

        // 商品検索リクエストの作成
        $request = new SearchItemsRequest();
        $request->setKeywords('Laravel Books');
        $request->setPartnerType(PartnerType::ASSOCIATES);
        $request->setPartnerTag($associateTag);

        // 商品検索の実行
        $apiInstance = new SearchItemsResource($client);
        $response = $apiInstance->searchItems($request);

        // レスポンスの処理
        $items = $response->getSearchResult()->getItems();
        // 商品情報を使って何かを行う

        return view('amazon.products', ['items' => $items]);
    }
}