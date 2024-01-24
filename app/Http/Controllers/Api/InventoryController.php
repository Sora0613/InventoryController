<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\In;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::all();
        return response()->json($inventory);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        //TODO : JANの選定の有無があるので要確認
        if ($user) {
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

            return response()->json(['message' => 'Stock added successfully']);
            //return response()->json(['message' => $request->all(), 'user' => $user]);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }

    // TODO : ここから下の関数は通常のControllerをみながら作成する。
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required|numeric',
        ]);

        $stock = Inventory::find($id);
        $stock->name = $request->input('name');
        $stock->quantity = $request->input('quantity');
        // 他の必要なカラムも追加
        $stock->save();

        return response()->json(['message' => 'Stock updated successfully', 'stock' => $stock]);
    }

    public function deleteStock($id)
    {
        $stock = Inventory::find($id);
        $stock->delete();

        return response()->json(['message' => 'Stock deleted successfully']);
    }

    public function search(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $stock = Inventory::where('name', 'like', '%' . $request->input('name') . '%')->get();

        return response()->json(['message' => 'Stock searched successfully', 'stock' => $stock]);
    }

    public function addQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric',
        ]);

        $stock = Inventory::find($id);
        $stock->quantity += $request->input('quantity');
        $stock->save();

        return response()->json(['message' => 'Stock quantity added successfully', 'stock' => $stock]);
    }

    public function reduceQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric',
        ]);

        $stock = Inventory::find($id);
        $stock->quantity -= $request->input('quantity');
        $stock->save();

        return response()->json(['message' => 'Stock quantity reduced successfully', 'stock' => $stock]);
    }
}
