@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-transparent border-0">
                    <div class="card-body text-center">
                        @guest
                            <h1 class="display-4 mb-3">{{ config('app.name', 'Laravel') }}</h1>
                            <p class="lead mb-4">Smart Pantryは、賢くて使いやすい食品在庫管理アプリケーションです。キッチンをスマートに整理し、食材の種類や残量を簡単に管理できます。</p>
                            <div>
                                <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Login') }}</a>
                                <a href="{{ route('register') }}" class="btn btn-secondary ml-2">{{ __('Register') }}</a>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
