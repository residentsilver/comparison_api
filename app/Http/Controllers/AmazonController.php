<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\comparison;
use RakutenRws_Client;

class AmazonController extends Controller
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
}
