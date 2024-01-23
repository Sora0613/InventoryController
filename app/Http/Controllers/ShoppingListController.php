<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ShoppingListController extends Controller
{
    public function index()
    {
        $usersLists = ShoppingList::where('user_id', Auth::user()->id)->get();
        return view('shoppingList.index', compact('usersLists'));
    }

    public function create()
    {
        return view('shoppingList.create');
    }

    public function show($id)
    {
        $list = ShoppingList::find($id);

        if ($list->user_id !== Auth::user()->id) {
            return redirect()->route('shoppinglist.index');
        }

        return view('shoppingList.show', compact('list'));
    }

    public function edit($id)
    {
        $list = ShoppingList::find($id);

        if ($list->user_id !== Auth::user()->id) {
            return redirect()->route('shoppinglist.index');
        }

        return view('shoppingList.edit', compact('list'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->id !== ShoppingList::find($id)->user_id) {
            return redirect()->route('shoppinglist.index');
        }

        try {
            $this->validate($request, [
                'title' => 'required|max:50',
                'body' => 'required|max:1000',
            ]);
        } catch (ValidationException $e) {
            redirect()->back()->withErrors($e->errors())->withInput();
        }

        $data = [
            'title' => $request->title,
            'content' => $request->body,
            'user_id' => Auth::user()->id,
        ];

        ShoppingList::where('id', $id)->update($data);

        $usersLists = ShoppingList::where('user_id', Auth::user()->id)->get();

        // with success message
        session()->flash('success', '買い物リストを更新しました。');
        return redirect()->route('shoppinglist.index', compact('usersLists'));
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|max:50',
                'body' => 'required|max:1000',
            ]);
        } catch (ValidationException $e) {
            redirect()->back()->withErrors($e->errors())->withInput();
        }

        $data = [
            'title' => $request->title,
            'content' => $request->body,
            'user_id' => Auth::user()->id,
        ];

        ShoppingList::create($data);

        $usersLists = ShoppingList::where('user_id', Auth::user()->id)->get();
        return view('shoppingList.index', compact('usersLists'));
    }

    public function destroy($id)
    {
        $list = ShoppingList::find($id);

        if ($list->user_id !== Auth::user()->id) {
            return redirect()->route('shoppinglist.index');
        }

        ShoppingList::destroy($id);

        $usersLists = ShoppingList::where('user_id', Auth::user()->id)->get();

        // with success message
        session()->flash('success', '買い物リストを削除しました。');
        return redirect()->route('shoppinglist.index', compact('usersLists'));
    }

}
