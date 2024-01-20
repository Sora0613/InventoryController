<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Lib\yahoo_api_jan_search as JanSearch;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // auth user's inventories
        $inventories = Inventory::where('user_id', Auth::id())->get();
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

        if (Inventory::where('user_id', Auth::id())->where('JAN', $newJanCode)->exists()) {
            $inventory = Inventory::where('user_id', Auth::id())->where('JAN', $newJanCode)->first();
            $inventory->quantity += $request->input('quantity') ?? 1;
            $inventory->save();
            $message = "商品：". $inventory->name . "の在庫が" . $inventory->quantity. "個になりました。";
            return view('inventory.search', compact("message"));
        }

        $data = [
            'name' => $request->input('name'),
            'JAN' => (int)$request->input('JAN'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity') ?? 1,
            'user_id' => Auth::id(),
            // Add other fields as necessary
        ];

        Inventory::create($data);
        $message = "商品：". $request->input('name'). "を追加しました。(JAN CODE)". $request->input('JAN');
        return view('inventory.search', compact("message"));
        //return redirect()->route('inventory.index');
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

        if($inventory->user_id !== Auth::id()){
            $message = "他のユーザーの在庫は見れません。";
            $inventories = Inventory::where('user_id', Auth::id())->get();
            return view('inventory.index', compact('message', 'inventories'));
        }

        return view('inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventory = Inventory::find($id);
        $inventories = Inventory::where('user_id', Auth::id())->get();

        if($inventory->user_id !== Auth::id()){
            return back()->with('error', '他のユーザーの在庫は編集できません。');
        }

        $request->validate([
            'name' => 'required',
            'JAN' => 'required|int',
            'price' => 'required|int',
            'quantity' => 'required|int',
        ]);

        $inventory->name = $request->input('name');
        $inventory->JAN = $request->input('JAN');
        $inventory->price = $request->input('price');
        $inventory->quantity = $request->input('quantity');
        $inventory->save();

        $message = "商品：". $request->input('name'). "の情報を更新しました。";
        return view('inventory.index', compact('message', 'inventories'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Inventory::destroy($id);
        return redirect()->route('inventory.index');
    }
}
