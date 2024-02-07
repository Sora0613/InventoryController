@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">LINE設定</div>
                    @isset($user_line)
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <img src="{{ $user_line->line_user_picture }}" width="100" height="100"
                                             alt="Line User Picture" class="img-fluid rounded-circle">
                                    </div>
                                </div>
                                <div class="col-md-8 align-self-center">
                                    <h3 class="mb-3">連携済みLINEアカウント</h3>
                                    <p class="mb-0">名前: {{ $user_line->line_user_name }}</p>
                                </div>
                            </div>
                        </div>
                    @endisset
                    <div class="card-body">
                        @if(Auth::user()->isLineExists())
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('line.logout') }}" class="btn btn-danger">ログアウト</a>
                            </div>
                        @else
                            <div class="d-flex justify-content-center mb-3">
                                <a href="{{ route('line.login') }}" class="image-button"></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
