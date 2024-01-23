@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">共有管理</div>

                    <div class="card-body">
                        @if(isset($url_success_message, $url))
                            <div class="alert alert-success" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill"/>
                                </svg>
                                {{ $url_success_message }}
                                <button id="copyButton" class="btn btn-outline-success">URLをコピー</button>
                                <div id="url" style="display: none;">{{ $url }}</div>
                            </div>
                        @endif

                        @isset($message)
                            <div class="alert alert-success" role="alert">
                                {{ $message }}
                            </div>
                        @endisset

                        共有者一覧
                        <br>
                        <a href="{{ route('collaborators.create') }}" class="btn btn-primary">共有者追加</a>
                        <a href="{{ route('collaborators.share') }}" class="btn btn-primary">共有リンク</a>
                        <br>
                        @isset($collaborators)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>共有者名</th>
                                    <th>共有者削除</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($collaborators as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>

                                        @if($user->id === Auth::id())
                                            <td>
                                                <form action="{{ route('collaborators.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('リストから本当に抜けますか？')">退会
                                                    </button>
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                <form action="{{ route('collaborators.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('本当に削除しますか？')">削除
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        @endisset
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
