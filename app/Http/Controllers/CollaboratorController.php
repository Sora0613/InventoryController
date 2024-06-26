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
    public function index()
    {
        $user = Auth::user();
        if ($user->isShared()) {
            $collaborators = User::where('share_id', Auth::user()->share_id)->get();
            return view('collaborators.index', compact('collaborators'));
        }
        $message = "共有できる人はいません。";
        return view('collaborators.index', compact('message'));
    }

    public function create()
    {
        return view('collaborators.create');
    }

    public function delete(int $collaborator)
    {
        $user = Auth::user();
        $collaborator = User::find($collaborator);

        if ($user->share_id === $collaborator->share_id) {
            //共有していたインベントリをnullに変更する。
            Inventory::where('share_id', $collaborator->share_id)
                ->where('user_id', $collaborator->id)
                ->update(['share_id' => null]);


            $collaborator->share_id = null;
            $collaborator->save();

            $collaborators = User::where('share_id', $user->share_id)->get();

            $message = "共有できる人から削除しました。";
            return redirect()->route('collaborators.index', compact('message', 'collaborators'));
        }

        $message = "削除できませんでした。";
        return view('collaborators.index', compact('message'));
    }


    public function share()
    {
        $user = Auth::user();
        if ($user->share_id === null) {
            $user->share_id = random_int(100, 9999999999);
            $user->save();

            $inventories = Inventory::where('user_id', Auth::id())->get();
            if ($inventories !== null) {
                foreach ($inventories as $inventory) {
                    $inventory->share_id = $user->share_id;
                    $inventory->save();
                }
            }
        }

        $collaborators = User::where('share_id', Auth::user()->share_id)->get();
        $url = 'http://localhost:8080/collaborators/invite/' . $user->share_id; //本番ではドメインを書き換える。
        $url_success_message = '招待URLが作成されました。';
        return view('collaborators.index', compact('url_success_message', 'url', 'collaborators'));
    }

    public function search(Request $request)
    {
        $email = $request->input('email');

        if ($email !== null) {
            $user = User::where('email', $email)->first();

            if ($user !== null) {
                $inviter = Auth::user();
                if ($inviter) {
                    $inviterName = $inviter->name;
                    if ($inviter->share_id === null) {
                        $inviter->share_id = random_int(100, 9999999999);
                        $inviter->save();

                        $inventories = Inventory::where('user_id', $inviter->id)->get();
                        if ($inventories !== null) {
                            foreach ($inventories as $inventory) {
                                $inventory->share_id = $inviter->share_id;
                                $inventory->save();
                            }
                        }
                    }

                    $invitationLink = 'http://localhost:8080/collaborators/invite/' . $inviter->share_id; //本番ではドメインを書き換える。
                    Mail::to($email)->send(new Invitation($inviterName, $invitationLink)); //Mailを送信。

                    $searchResults = 'ユーザーに招待メールを送信しました。';
                    return view('collaborators.create', compact('searchResults', 'user'));
                }
            }

            $searchResults = 'ユーザーが見つかりませんでした。';
            return view('collaborators.create', compact('searchResults'));
        }

        $searchResults = 'Emailが存在しません。';
        return view('collaborators.create', compact('searchResults'));
    }

    public function invited(int $share_id)
    {
        /* 招待を受け取った後に開くページ。
         * 原則、1人が参加できるのは一つのリストとする。
         * すでにどこかのリストに参加している場合は、参加できないようにする。
         */

        $user = Auth::user();

        if ($user === null) {
            return redirect()->route('inventory.index');
        }

        if ($user->share_id === $share_id) {
            $message = "すでに招待を受け取っています。";
            return view('collaborators.invited', compact('message'));
        }

        if ($user->share_id !== null) {
            $message = "すでにどこかのリストに参加しているため、参加することができません。";
            return view('collaborators.invited', compact('message'));
        }

        //どこのリストにも参加していない新規のユーザー
        $user->share_id = $share_id; // share_idを新しい乱数で更新
        $user->save(); // ユーザー情報を保存

        //Auth::user()のInventoryのshare_idも更新する
        $inventories = Inventory::where('user_id', $user->id)->get();
        if ($inventories !== null) {
            foreach ($inventories as $inventory) {
                $inventory->share_id = $share_id;
                $inventory->save();
            }
        }

        $success_message = "招待を受け取りました。";
        return view('collaborators.invited', compact('success_message'));
    }
}
