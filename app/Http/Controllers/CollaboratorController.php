<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollaboratorController extends Controller
{
    /*
     * 在庫リストを共有できる人の管理をここで行いたい。
     * 用意したい関数
     * 1. 共有できる人の追加
     * 2. 共有できる人の削除
     * 3. 共有できる人の一覧表示
     * 4. 共有できる人の検索
     * 共有できる人の情報は、ユーザー名とメールアドレスだけでいいかも。Auth::user()から取得できる情報でどうにかする。
     */

    public function index()
    {
        return view('collaborators.index');
    }

    public function addUser()
    {
        // 共有できる人の追加(view)
    }

    public function store()
    {
        // 共有できる人の追加(system)
    }

    public function show()
    {
        // 共有できる人
    }

    public function deleteUser()
    {
        // 共有できる人の削除
    }
}
