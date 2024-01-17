<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>在庫登録</title>
</head>
<body>
    <h1>在庫登録</h1>
    <a href="{{ route('inventory.index') }}" class="btn btn-primary">在庫一覧</a>
    <a href="{{ route('inventory.create') }}" class="btn btn-primary">在庫登録</a>

    <br>
    <br>

    <form action="{{ route('inventory.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">商品名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div>
            <label for="JAN">JANコード</label>
            <input type="text" name="JAN" id="JAN" value="{{ old('JAN') }}">
        </div>
        <div>
            <label for="price">価格</label>
            <input type="text" name="price" id="price" value="{{ old('price') }}">
        </div>
        <button type="submit">登録</button>
    </form>
</body>
</html>
