@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">在庫登録</div>

                    <div class="card-body">
                        <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
                        <a href="{{ route('inventory.index') }}" class="btn btn-primary">在庫一覧</a>
                        <a href="{{ route('inventory.create') }}" class="btn btn-primary">在庫登録</a>
                        <a href="{{ route('inventory.search') }}" class="btn btn-primary">Jan検索</a>
                        <br>
                        <br>
                        <form>
                            <div class="form-group">
                                <label for="name">商品名</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       @isset($product_info)
                                           value="{{ $product_info['hits'][0]['name'] }}"
                                       @endisset>

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
                            <br>
                            <button type="submit" class="btn btn-primary">登録</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
