<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AmazonCurlController extends Controller
{
    public function searchAmazonProducts()
    {
        include_once '/home/itsys/public_html/practice/board-login/amazon.php';
        $amazonData = $response;

        // $items = Storage::get('/home/itsys/public_html/practice/board-login/amazon.php'->$host);
        return view('comparisons.amazon',['items' => $amazonData]);
    }
}
