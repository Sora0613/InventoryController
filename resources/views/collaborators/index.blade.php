@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">共有管理</div>

                    <div class="card-body">
                        @if(isset($message, $url))
                            <div class="alert alert-success" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                {{ $message }}
                                <button id="copyButton" class="btn btn-outline-success">URLをコピー</button>
                                <div id="url" style="display: none;">{{ $url }}</div>
                            </div>
                        @endif

                        共有者一覧
                        <br>
                        <a href="{{ route('collaborators.create') }}" class="btn btn-primary">共有者追加</a>
                        <a href="{{ route('collaborators.share') }}" class="btn btn-primary">共有リンク</a>
                        <br>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>共有者名</th>
                                <th>共有者メールアドレス</th>
                                <th>共有者権限</th>
                                <th>共有者編集</th>
                                <th>共有者削除</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td>Name</td>
                                <td>Mail</td>
                                <td>Role</td>
                                <td><a href="#" class="btn btn-primary">編集</a></td>
                                <td>
                                    <form action="#" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('本当に削除しますか？')">削除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('copyButton').addEventListener('click', function () {
                var url = document.getElementById('url').innerText;
                navigator.clipboard.writeText(url).then(function () {
                    alert('URLがクリップボードにコピーされました');
                }).catch(function (error) {
                    alert('エラー: ' + error);
                });
            });
        });
    </script>
@endsection
