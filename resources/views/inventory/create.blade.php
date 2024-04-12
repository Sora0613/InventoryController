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
                        <form action="{{ route('inventory.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">商品名</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       @isset($product_info)
                                           value="{{ $product_info['hits'][0]['name'] }}"
                                       @endisset required>

                            </div>
                            <div class="form-group">
                                <label for="JAN">JANコード</label>
                                <input type="text" name="JAN" id="JAN" class="form-control"
                                       @isset($product_info)
                                           value="{{ $product_info['hits'][10]['janCode'] }}"
                                       @endisset>
                            </div>
                            <div class="form-group">
                                <label for="price">価格</label>
                                <input type="text" name="price" id="price" class="form-control"
                                       @isset($product_info)
                                           value="{{ $product_info['hits'][2]['price'] }}"
                                       @endisset>
                            </div>
                            <div class="form-group">
                                <label for="expiration_date">賞味期限</label>
                                <input type="date" name="expiration_date" id="expiration_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="quantity">数量</label>
                                <input type="text" name="quantity" id="quantity" class="form-control" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">登録</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
