<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>在庫登録</title>
</head>
<body>
    <h1>在庫登録</h1>
    <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
    <a href="{{ route('inventory.index') }}" class="btn btn-primary">在庫一覧</a>
    <a href="{{ route('inventory.create') }}" class="btn btn-primary">在庫登録</a>
    <a href="{{ route('inventory.search') }}" class="btn btn-primary">Jan検索</a>

    <br>
    <br>

    <form action="{{ route('inventory.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">商品名</label>
            <input type="text" name="name" id="name"
                   @isset($product_info)
                       value="{{ $product_info['hits'][0]['name'] }}"
                   @endisset>
        </div>
        <div>
            <label for="JAN">JANコード</label>
            <input type="text" name="JAN" id="JAN"
                   @isset($product_info)
                        value="{{ $product_info['hits'][10]['janCode'] }}"
                   @endisset>
        </div>
        <div>
            <label for="price">価格</label>
            <input type="text" name="price" id="price"
                   @isset($product_info)
                       value="{{ $product_info['hits'][2]['price'] }}"
                   @endisset>
        </div>
        <button type="submit">登録</button>
    </form>
</body>
</html>
