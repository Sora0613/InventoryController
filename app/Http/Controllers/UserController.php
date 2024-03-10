<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if($user) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
            ]);

            if ($request->name === $user->name && $request->email === $user->email) {
                return redirect()->route('user.edit')->with('message', '変更がありません');
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return redirect()->route('user.edit')->with('message', 'ユーザー情報を更新しました');
        }
        return redirect()->route('user.edit')->with('message', 'ユーザー情報の更新に失敗しました');
    }



    public function ToggleTheme()
    {
        $user = Auth::user();
        $user->changeTheme();
        return back();
    }
}
