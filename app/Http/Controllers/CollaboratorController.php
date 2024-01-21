<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            }

            $url = 'http://localhost:8000/collaborators/invite/'.$user->share_id; //本番ではドメインを書き換える。
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
                /* 手順メモ
                 * 1. ユーザーに招待メールを送信する(と同時に、userのshare_idを生成する)
                 * 2. メールを送信した際に、invitationテーブルにaccept以外のレコードを追加する
                 * 3. メールを受け取ったユーザーが、招待メールのURLをクリックすると、acceptのレコードを追加する
                 * →招待リンクをクリックした際に、invitationがきているかの確認を行い、招待がきていなければ、招待がきていませんと表示する。
                 * →created_atの時間から計算して、24時間以内に招待リンクをクリックしないと、招待が無効になるようにする。
                 */
                $searchResults = 'ユーザーに招待メールを送信しました。';
                return view('collaborators.create', compact( 'searchResults', 'user'));
            }

            $searchResults = 'ユーザーが見つかりませんでした。';
            return view('collaborators.create', compact( 'searchResults'));
        }

        $searchResults = 'Emailが存在しません。';
        return view('collaborators.create', compact( 'searchResults'));
    }

    public function invite(string $share_id)
    {
        // 招待を受け取るリンクでどうですか。
        $user = User::where('share_id', $share_id)->first();
        if($user !== null){
            $invitation = [
                'inviter_id' => $user->id,
                'invitee_id' => Auth::id(),
                'share_id' => $user->share_id,
                'email' => $user->email,
                'accepted' => false,
            ];
            return view('collaborators.invite', compact('invitation'));
        }
        return redirect()->route('inventory.index');
    }
}
