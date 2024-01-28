<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\yahoo_api_jan_search as JanSearch;
use App\Models\Inventory;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\In;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $share_id = $user->share_id;

        if ($share_id === null) {
            $inventories = Inventory::where('user_id', $user->id)->get();
            return response()->json($inventories);
        }

        $inventories = Inventory::where('user_id', $user->id)
            ->orWhere('share_id', $share_id)
            ->get();
        return response()->json($inventories);
    }

    public function directStore(Request $request)
    {
        $user = $request->user();
        $share_id = $user->share_id;

        if ($user) {
            if ($request->JAN !== null) {
                $product_info = (new JanSearch)->search($request->JAN);
                $newJanCode = $request->JAN;

                // 共有済み
                if (($share_id !== null)) {
                    if (Inventory::where('share_id', $share_id)->where('JAN', $newJanCode)->exists()) {
                        $inventory = Inventory::where('share_id', $share_id)->where('JAN', $newJanCode)->first();
                        $inventory->quantity++;
                        $inventory->save();
                        $message = "商品：" . $inventory->name . "の在庫が" . $inventory->quantity . "個になりました。";
                        return response()->json(['message' => $message]);
                    }
                }

                // 共有していない
                if (Inventory::where('user_id', $user->id)->where('JAN', $newJanCode)->exists()) {
                    $inventory = Inventory::where('user_id', $user->id)->where('JAN', $newJanCode)->first();
                    $inventory->quantity++;
                    $inventory->save();
                    $message = "商品：" . $inventory->name . "の在庫が" . $inventory->quantity . "個になりました。";
                    return response()->json(['message' => $message]);
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

                $message = "商品：" . $product_info['hits'][0]['name'] . "を追加しました。(JAN CODE)" . $product_info['hits'][10]['janCode'];

                return response()->json(['message' => $message]);
            }
        }
        return response()->json(['error' => 'ログインされていません。'], 401);
    }

    public function store(Request $request)
    {
        //TODO: Flutter側で画面を読み込む際に、新たにinventoryの取得が必要そうであればここで取得し、値の受け渡しを行う。
        $user = $request->user();
        $enteredJanCode = $request->JAN;
        $share_id = $user->share_id;

        if ($user) {
            //他のユーザーに共有している。
            if (($share_id !== null)) {
                if (Inventory::where('share_id', $share_id)->where('JAN', $enteredJanCode)->exists()) {
                    $inventory = Inventory::where('share_id', $share_id)->where('JAN', $enteredJanCode)->first();
                    $inventory->quantity += $request->input('quantity') ?? 1;
                    $inventory->save();
                    $message = "商品：" . $inventory->name . "の在庫が" . $inventory->quantity . "個になりました。";
                    return response()->json(['message' => $message]);
                }
            }

            // 共有していない
            if (Inventory::where('user_id', $user->id)->where('JAN', $enteredJanCode)->exists()) {
                $inventory = Inventory::where('user_id', $user->id)->where('JAN', $enteredJanCode)->first();
                $inventory->quantity += $request->input('quantity') ?? 1;
                $inventory->save();
                $message = "商品：" . $inventory->name . "の在庫が" . $inventory->quantity . "個になりました。";
                return response()->json(['message' => $message]);
            }

            //そもそも新製品
            $data = [
                'name' => $request->name,
                'JAN' => (int)$request->JAN,
                'price' => 0 ?? (int)$request->price,
                'quantity' => $request->quantity ?? 1,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'share_id' => $user->share_id ?? null,
            ];

            Inventory::create($data);
            return response()->json(['message' => '在庫の追加が完了しました。']);
        }
        return response()->json(['error' => 'ログインされていません。'], 401);
    }

    public function update(Request $request, int $id)
    {
        $item = Inventory::find($id);
        $user = $request->user();
        $inventories = Inventory::where('user_id', $user->id)->get();

        if ($item->user_id === $user->id or $item->share_id === $user->share_id) {

            $request->validate([
                'name' => 'required',
                'JAN' => 'required|int',
                'price' => 'required|int',
                'quantity' => 'required|int',
            ]);

            $item->name = $request->input('name');
            $item->JAN = $request->input('JAN');
            $item->price = $request->input('price');
            $item->quantity = $request->input('quantity');
            $item->save();

            return response()->json(['message' => '在庫の更新が完了しました。', 'inventories' => $inventories]);
        }

        return response()->json(['message' => '他のユーザーの在庫は編集できません。']);
    }

    public function delete($id)
    {
        $stock = Inventory::find($id);
        $stock->delete();

        return response()->json(['message' => '在庫の削除が完了しました。']);
    }

    public function addQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric',
        ]);

        $item = Inventory::find($id);
        $user = $request->user();
        $inventories = Inventory::where('user_id', $user->id)->get();

        $item->quantity++;
        $item->save();

        return response()->json(['inventories' => $inventories]);
    }

    public function reduceQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric',
        ]);

        $item = Inventory::find($id);
        $user = $request->user();
        $inventories = Inventory::where('user_id', $user->id)->get();

        $item->quantity--;
        $item->save();

        return response()->json(['inventories' => $inventories]);
    }
}
