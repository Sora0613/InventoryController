@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        <br>
                    @endif
                        <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
                        <a href="{{ route('inventory.index') }}" class="btn btn-primary">在庫一覧</a>
                        <a href="{{ route('inventory.create') }}" class="btn btn-primary">在庫登録</a>
                        <a href="{{ route('inventory.search') }}" class="btn btn-primary">Jan検索</a>
                        <br>
                        You logged in as {{ Auth::user()->name }}!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
