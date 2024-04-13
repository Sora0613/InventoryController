<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\LineInformation;
use Illuminate\Http\Request;
use App\Lib\yahoo_api_jan_search as JanSearch;
use Illuminate\Support\Facades\Auth;
use App\Lib\LineFunctions as Line;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        $share_id = Auth::user()->share_id;

        if ($share_id === null) {
            $inventories = Inventory::where('user_id', $user_id)->get();
            return view('inventory.index', compact('inventories'));
        }

        $inventories = Inventory::where('user_id', $user_id)->orWhere('share_id', $share_id)->get();
        return view('inventory.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newJanCode = $request->input('JAN');
        $share_id = Auth::user()->share_id;

        /* 共有していない場合と共有している場合で処理を分ける
         * 共有していない場合は、user_idからそのまま参照する。
         * 共有している場合は、share_idから参照する。
         */

        // 共有済み
        if ($share_id !== null) {
            if (Inventory::where('share_id', $share_id)->where('JAN', $newJanCode)->exists()) {
                $inventory = Inventory::where('share_id', $share_id)->where('JAN', $newJanCode)->first();
                $inventory->quantity += $request->input('quantity') ?? 1;
                $inventory->save();
                $message = "商品：" . $inventory->name . "の在庫が" . $inventory->quantity . "個になりました。";
                return view('inventory.searchJan', compact("message"));
            }
        }

        // 共有していない
        if (Inventory::where('user_id', Auth::id())->where('JAN', $newJanCode)->exists()) {
            $inventory = Inventory::where('user_id', Auth::id())->where('JAN', $newJanCode)->first();
            $inventory->quantity += $request->input('quantity') ?? 1;
            $inventory->save();
            $message = "商品：" . $inventory->name . "の在庫が" . $inventory->quantity . "個になりました。";
            return view('inventory.searchJan', compact("message"));
        }

        //そもそもJANが登録されていない。
        $data = [
            'name' => $request->input('name'),
            'JAN' => $request->input('JAN') ?? null,
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity') ?? 1,
            'expiration_date' => $request->input('expiration_date'),
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'share_id' => Auth::user()->share_id ?? null,
        ];

        Inventory::create($data);
        $message = "商品：" . $request->input('name') . "を追加しました。(JAN CODE)" . $request->input('JAN');
        return view('inventory.searchJan', compact("message"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory = Inventory::find($id);

        if (($inventory->user_id === Auth::id()) or ($inventory->share_id === Auth::user()->share_id)) {
            return view('inventory.edit', compact('inventory'));
        }

        $message = "他のユーザーの在庫は見れません。";
        $inventories = Inventory::where('user_id', Auth::id())->orWhere('share_id', Auth::user()->share_id)->get();
        return view('inventory.index', compact('message', 'inventories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventory = Inventory::find($id);
        $inventories = Inventory::where('user_id', Auth::id())->get();


        if ($inventory->user_id === Auth::id() or $inventory->share_id === Auth::user()->share_id) {

            if ($request->has('add-btn')) {
                $inventory->quantity++;
                $inventory->save();
                return redirect()->route('inventory.index', compact('inventories'));
            }

            if ($request->has('reduce-btn')) {
                $inventory->quantity--;
                $inventory->save();

                if ($inventory->quantity === 0) {

                    if (Auth::user()->isLineExists()) {
                        $line = new Line(Auth::user()->getLineId());
                        $line->sendMessage("[在庫通知]" . $inventory->name . "の在庫がなくなりました。");
                    }

                    $inventory->delete();
                }

                if (($inventory->quantity === 1) && Auth::user()->isLineExists()) {
                    $line = new Line(Auth::user()->getLineId());
                    $line->sendMessage( "[在庫通知]" . $inventory->name . "の在庫が残り1個になりました。");
                }

                return redirect()->route('inventory.index', compact('inventories'));
            }

            $request->validate([
                'name' => 'required',
                'price' => 'required|int',
                'quantity' => 'required|int',
                'expiration_date' => 'date|nullable',
            ]);

            $inventory->name = $request->input('name');
            $inventory->JAN = $request->input('JAN') ?? null;
            $inventory->price = $request->input('price');
            $inventory->quantity = $request->input('quantity');
            $inventory->expiration_date = $request->input('expiration_date');
            $inventory->save();

            return redirect()->route('inventory.index', compact('inventories'));
        }
        return back()->with('error', '他のユーザーの在庫は編集できません。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Inventory::destroy($id);
        return redirect()->route('inventory.index');
    }

    public function searchItems(Request $request){
        $key = $request->input('keyword');

        $user_id = Auth::id();
        $share_id = Auth::user()->share_id;

        // 検索フォームが空欄の場合、全ての在庫を表示する。
        if($key === null){
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
