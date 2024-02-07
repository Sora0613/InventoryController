@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">LINE関連テストBlade</div>

                    <div class="card-body">
                        <a href="{{ route('line.send') }}" class="btn btn-primary">テストメッセージ送信</a>
                        <br>
                        <br>
                        <a href="{{ route('line.login') }}">
                            <button class="image-button"></button>
                        </a>
                        <br>
                        <a href="{{ route('line.logout') }}" class="btn btn-danger">ログアウト</a>


                    </div>
                    @isset($user_line)
                        <div class="card-body">
                            <h3>Line User Info</h3>
                            <p>Line ID: {{ $user_line->line_user_id }}</p>
                            <p>Display Name: {{ $user_line->line_user_name }}</p>
                            <p>Picture URL: <img src="{{ $user_line->line_user_picture }}" alt="Line User Picture"></p>
                        </div>
                    @endisset

                </div>
            </div>
        </div>
    </div>
@endsection

