<?php

namespace App\Http\Controllers;

use App\Lib\yahoo_api_jan_search as JanSearch;
use Illuminate\Http\Request;

class SearchJanController extends Controller
{
    public function search(Request $request)
    {
        // JANを取得して、検索し、Jsonを返す。redirectでcreate画面のテキストボックスにJANと商品名をすでに入れた状態にする。
        if($request->input('JAN') !== null){
            $product_info = (new JanSearch)->search($request->JAN);
            return view('inventory.create', compact('product_info'));
        }
        return view('inventory.search');
    }
}
