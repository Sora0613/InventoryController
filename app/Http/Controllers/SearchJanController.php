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
        $user_agent = $request->header('User-Agent');
        // get user agent and check smartphone or pc
        if ((strpos($user_agent, 'iPhone') !== false)
            || (strpos($user_agent, 'iPod') !== false)
            || (strpos($user_agent, 'Android') !== false)) {
            $terminal ='mobile';
        } else {
            $terminal = 'pc';
        }

        // JANを取得して、検索し、Jsonを返す。redirectでcreate画面のテキストボックスにJANと商品名をすでに入れた状態にする。
        if($request->input('JAN') !== null){
            $product_info = (new JanSearch)->search($request->JAN);
            $newJanCode = $request->input('JAN');

            if ($request->has('register')) {
                return view('inventory.create', compact('product_info'));
            }

            //JANで検索した商品をそのまま直接追加。
            if($request->has('register-directly')) {
                $share_id = Auth::user()->share_id;
                /* 共有していない場合と共有している場合で処理を分ける
                 * 共有していない場合は、user_idからそのまま参照する。
                 * 共有している場合は、share_idから参照する。
                 */

                // 共有済み
                if(($share_id !== null)) {
                    if (Inventory::where('share_id', $share_id)->where('JAN', $newJanCode)->exists()) {
                        $inventory = Inventory::where('share_id', $share_id)->where('JAN', $newJanCode)->first();
                        $inventory->quantity += $request->input('quantity') ?? 1;
                        $inventory->save();
                        $message = "商品：". $inventory->name . "の在庫が" . $inventory->quantity. "個になりました。";
                        return view('inventory.search', compact("message", "terminal"));
                    }
                }

                // 共有していない
                if (Inventory::where('user_id', Auth::id())->where('JAN', $newJanCode)->exists()) {
                    $inventory = Inventory::where('user_id', Auth::id())->where('JAN', $newJanCode)->first();
                    $inventory->quantity += $request->input('quantity') ?? 1;
                    $inventory->save();
                    $message = "商品：". $inventory->name . "の在庫が" . $inventory->quantity. "個になりました。";
                    return view('inventory.search', compact("message", "terminal"));
                }

                // そもそも存在しない
                $data = [
                    'name' => $product_info['hits'][0]['name'],
                    'JAN' => $product_info['hits'][10]['janCode'],
                    'price' => $product_info['hits'][2]['price'],
                    'quantity' => 1,
                    'user_id' => Auth::id(),
                    'user_name' => Auth::user()->name,
                ];
                Inventory::create($data);

                $message = "商品：". $product_info['hits'][0]['name']. "を追加しました。(JAN CODE)". $product_info['hits'][10]['janCode'];

                return view('inventory.search', compact("message", "terminal"));
            }
        }



        return view('inventory.search', compact("terminal"));
    }
}
