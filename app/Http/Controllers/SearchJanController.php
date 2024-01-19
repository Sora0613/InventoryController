<?php

namespace App\Http\Controllers;

use App\Lib\yahoo_api_jan_search as JanSearch;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchJanController extends Controller
{
    public function search(Request $request)
    {
        // JANを取得して、検索し、Jsonを返す。redirectでcreate画面のテキストボックスにJANと商品名をすでに入れた状態にする。
        if($request->input('JAN') !== null){
            $product_info = (new JanSearch)->search($request->JAN);

            if ($request->has('register')) {
                return view('inventory.create', compact('product_info'));
            }

            //JANで検索した商品をそのまま直接追加。
            if($request->has('register-directly')) {
                $data = [
                    'name' => $product_info['hits'][0]['name'],
                    'JAN' => $product_info['hits'][10]['janCode'],
                    'price' => $product_info['hits'][2]['price'],
                    'user_id' => Auth::id(),
                ];
                Inventory::create($data);

                $message = "商品：". $product_info['hits'][0]['name']. "を追加しました。(JAN CODE)". $product_info['hits'][10]['janCode'];

                return view('inventory.search', compact("message"));
            }
        }
        return view('inventory.search');
    }
}
