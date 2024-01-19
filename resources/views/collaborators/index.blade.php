@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">共有管理</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            <br>
                        @endif
                        共有者一覧
                        <br>
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
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
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
@endsection
