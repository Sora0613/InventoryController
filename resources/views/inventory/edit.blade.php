@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">在庫登録</div>

                    <div class="card-body">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    <li>{{$error}}</li>
                                </ul>
                            </div>
                        @endforeach
                        @isset($inventory)
                            <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">商品名</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $inventory->name }}" required>

                                </div>
                                <div class="form-group">
                                    <label for="JAN">JANコード</label>
                                    <input type="text" name="JAN" id="JAN" class="form-control" value="{{ $inventory->JAN }}">
                                </div>
                                <div class="form-group">
                                    <label for="price">価格</label>
                                    <input type="text" name="price" id="price" class="form-control" value="{{ $inventory->price }}">
                                </div>
                                <div class="form-group">
                                    <label for="expiration_date">賞味期限</label>
                                    <input type="date" name="expiration_date" id="expiration_date" class="form-control" value="{{ $inventory->expiration_date }}">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">数量</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" value="{{ $inventory->quantity }}" required>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">登録</button>
                            </form>
                        @else
                            <div class="alert alert-danger" role="alert">
                                商品情報がありません - <a href="{{ route('inventory.index') }}" class="alert-link">在庫一覧へ</a>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
