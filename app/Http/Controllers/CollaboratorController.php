<?php

namespace App\Http\Controllers;

use App\Mail\Invitation;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function create()
    {
        return view('collaborators.create');
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

    public function edit()
    {
        // 共有できる人の編集
    }

    public function update()
    {
        // 共有できる人の更新
    }

    public function share()
    {
        /*
         * 手順メモ
         * 1. 招待のためのURLを作成する
         * 2. 招待のためのURLをクリップボードにコピーさせる
         * 3. 招待のためのURLをクリップボードにコピーさせたことをユーザーに通知する
         * (invitationテーブルに、招待した人のIDと招待された人のIDを保存する)
         */
        // userのshare_idを生成する
        $user = Auth::user();
        if($user !== null){

            if($user->share_id === null){
                $user->share_id = random_int(100, 9999999999); // share_idを新しい乱数で更新
                $user->save(); // ユーザー情報を保存

                //Auth::user()のInventoryのshare_idも更新する
                $inventories = Inventory::where('user_id', Auth::id())->get();
                if($inventories !== null) {
                    foreach ($inventories as $inventory) {
                        $inventory->share_id = $user->share_id;
                        $inventory->save();
                    }
                }
            }

            $url = 'http://localhost:8080/collaborators/invite/'.$user->share_id; //本番ではドメインを書き換える。
            $message = '招待URLが作成されました。';
            return view('collaborators.index', compact('message', 'url'));
        }
        return redirect()->route('inventory.index');
    }

    public function search(Request $request)
    {
        $email = $request->input('email');

        if($email !== null){
            $user = User::where('email', $email)->first();

            if($user !== null){
                $inviterName = Auth::user()->name;

                $invitationLink = 'http://localhost:8080/collaborators/invite/'. Auth::user()->share_id; //本番ではドメインを書き換える。
                Mail::to($email)->send(new Invitation($inviterName, $invitationLink)); //Mailを送信。

                $searchResults = 'ユーザーに招待メールを送信しました。';
                return view('collaborators.create', compact( 'searchResults', 'user'));
            }

            $searchResults = 'ユーザーが見つかりませんでした。';
            return view('collaborators.create', compact( 'searchResults'));
        }

        $searchResults = 'Emailが存在しません。';
        return view('collaborators.create', compact( 'searchResults'));
    }

    public function invited(int $share_id)
    {
        /* 招待を受け取った後に開くページ。
         * 原則、1人が参加できるのは一つのリストとする。
         * すでにどこかのリストに参加している場合は、参加できないようにする。
         */

        $user = Auth::user();

        if($user === null)
        {
            return redirect()->route('inventory.index');
        }

        if($user->share_id === $share_id)
        {
            $message = "すでに招待を受け取っています。";
            return view('collaborators.invited', compact('message'));
        }

        if($user->share_id !== null)
        {
            $message = "すでにどこかのリストに参加しているため、参加することができません。";
            return view('collaborators.invited', compact('message'));
        }

        //どこのリストにも参加していない新規のユーザー
        $user->share_id = $share_id; // share_idを新しい乱数で更新
        $user->save(); // ユーザー情報を保存

        //Auth::user()のInventoryのshare_idも更新する
        $inventories = Inventory::where('user_id', $user->id)->get();
        if($inventories !== null)
        {
            foreach ($inventories as $inventory) {
                $inventory->share_id = $share_id;
                $inventory->save();
            }
        }

        $success_message = "招待を受け取りました。";
        return view('collaborators.invited', compact('success_message'));
    }
}
