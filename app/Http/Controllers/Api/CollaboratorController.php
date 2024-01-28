<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\Invitation;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CollaboratorController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->share_id === null) {
            $message = "共有できる人はいません。";
            return response()->json(['message' => $message]);
        }
        $collaborators = User::where('share_id', $user->share_id)->get();
        return response()->json($collaborators);
    }

    public function share(Request $request)
    {
        $user = $request->user();
        if ($user !== null) {
            if ($user->share_id === null) {
                $user->share_id = random_int(100, 9999999999);
                $user->save();

                $inventories = Inventory::where('user_id', $user->id)->get();
                if ($inventories !== null) {
                    foreach ($inventories as $inventory) {
                        $inventory->share_id = $user->share_id;
                        $inventory->save();
                    }
                }
            }

            $collaborators = User::where('share_id', $user->share_id)->get();
            $url = 'http://localhost:8080/collaborators/invite/' . $user->share_id; //本番ではドメインを書き換える。
            $url_success_message = '招待URLが作成されました。';
            return response()->json(['url' => $url, 'url_success_message' => $url_success_message, 'collaborators' => $collaborators]);
        }
        return response()->json(['message' => '共有を許可できませんでした。']);
    }

    public function search(Request $request)
    {
        $email = $$request->email;

        if ($email !== null) {
            $user = User::where('email', $email)->first();

            if ($user !== null) {
                $inviterName = $request->user()->name;

                $invitationLink = 'http://localhost:8080/collaborators/invite/' . $request->user()->share_id; //本番ではドメインを書き換える。
                Mail::to($email)->send(new Invitation($inviterName, $invitationLink)); //Mailを送信。

                $searchResults = 'ユーザーに招待メールを送信しました。';
                return response()->json(['searchResults' => $searchResults]);
            }

            $searchResults = 'ユーザーが見つかりませんでした。';
            return response()->json(['searchResults' => $searchResults]);
        }

        $searchResults = 'Emailが存在しません。';
        return response()->json(['searchResults' => $searchResults]);
    }

    public function delete(Request $request, int $collaborator)
    {
        $collaborator = User::find($collaborator);
        $user = $request->user();

        if ($user->share_id === $collaborator->share_id) {
            //共有していたインベントリをnullに変更する。
            $inventories = Inventory::where('share_id', $collaborator->share_id)->get();
            foreach ($inventories as $inventory) {
                if ($inventory->user_id === $collaborator->id) {
                    $inventory->share_id = null;
                    $inventory->save();
                }
            }
            //共有を行なっていたユーザーのshare_idをnullに変更する。
            $collaborator->share_id = null;
            $collaborator->save();

            $collaborators = User::where('share_id', $user->share_id)->get();

            $message = "共有できる人から削除しました。";
            return response()->json(['message' => $message, 'collaborators' => $collaborators]);
        }
        $message = "削除できませんでした。";
        return response()->json(['message' => $message]);
    }

}
