@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">在庫登録</div>
                    <div class="card-body">
                        @isset($message)
                            <div class="alert alert-success" role="alert">
                                {{ $message }} - <a href="{{ route('inventory.index') }}" class="alert-link">在庫一覧へ</a>
                            </div>
                            <br>
                        @endisset

                        <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
                        <a href="{{ route('inventory.index') }}" class="btn btn-primary">在庫一覧</a>
                        <a href="{{ route('inventory.create') }}" class="btn btn-primary">在庫登録</a>
                        <a href="{{ route('inventory.search') }}" class="btn btn-primary">Jan検索</a>
                        <br>
                        <br>
                        <form action="{{ route('inventory.search') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="JAN">JANコード</label>
                                <input class="form-control" type="text" name="JAN" id="JAN" value="{{ old('JAN') }}" required>
                            </div>
                            <br>
                            <button class="btn btn-primary" type="submit" name="register">登録</button>
                            <button class="btn btn-primary" type="submit" name="register-directly">直接登録</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

