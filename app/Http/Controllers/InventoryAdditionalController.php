<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\LineInformation;
use Illuminate\Http\Request;
use App\Lib\yahoo_api_jan_search as JanSearch;
use Illuminate\Support\Facades\Auth;
use App\Lib\LineFunctions as Line;

class InventoryAdditionalController extends Controller
{
    public function searchItems(Request $request)
    {
        $key = $request->input('keyword');

        $user_id = Auth::id();
        $share_id = Auth::user()->share_id;

        // 検索フォームが空欄の場合、全ての在庫を表示する。
        if ($key === null) {
            if ($share_id === null) {
                $inventories = Inventory::where('user_id', $user_id)->get();
                return view('inventory.index', compact('inventories'));
            }

            $inventories = Inventory::where('user_id', $user_id)->orWhere('share_id', $share_id)->get();
            return view('inventory.index', compact('inventories'));
        }

        // 検索フォームに入力されたキーワードで検索する。
        if ($share_id === null) {
            $inventories = Inventory::where('user_id', $user_id)->where('name', 'like', "%$key%")->get();
            return view('inventory.index', compact('inventories'));
        }

        $inventories = Inventory::where('share_id', $share_id)->where('name', 'like', "%$key%")->get();
        return view('inventory.index', compact('inventories'));
    }
}
