<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShoppingList;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ShoppingListController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user_memo = ShoppingList::where('user_id', $user->id)->get();
        return response()->json($user_memo);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        try {
            $this->validate($request, [
                'title' => 'required|max:50',
                'body' => 'required|max:1000',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'タイトルと本文の両方が必須です。']);
        }

        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $user->id,
        ];
        ShoppingList::create($data);
        return response()->json(['message' => 'メモを作成しました。']);
    }

    // TODO: 以下の部分はFlutter側の実装を完了してから様子見つつやる。
    /*public function show(Request $request, $id)
    {
        $user = $request->user();
        $memo = ShoppingList::find($id);

        if ($memo->user_id !== $user->id) {
            return response()->json(['message' => 'メモが見つかりません。']);
        }

        return response()->json($memo);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $memo = ShoppingList::find($id);

        if ($memo->user_id !== $user->id) {
            return response()->json(['message' => 'メモが見つかりません。']);
        }

        try {
            $this->validate($request, [
                'title' => 'required|max:50',
                'body' => 'required|max:1000',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'タイトルと本文の両方が必須です。']);
        }

        $data = [
            'title' => $request->title,
            'body' => $request->body,
        ];
        $memo->fill($data)->save();
        return response()->json(['message' => 'メモを更新しました。']);
    }*/

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $memo = ShoppingList::find($id);

        if ($memo->user_id !== $user->id) {
            return response()->json(['message' => 'メモが見つかりません。']);
        }

        $memo->delete();
        return response()->json(['message' => 'メモを削除しました。']);
    }
}
