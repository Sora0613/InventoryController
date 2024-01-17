<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>在庫登録</title>
</head>
<body>
<h1>Jan検索</h1>
<a href="{{ route('home') }}" class="btn btn-primary">Home</a>
<a href="{{ route('inventory.index') }}" class="btn btn-primary">在庫一覧</a>
<a href="{{ route('inventory.create') }}" class="btn btn-primary">在庫登録</a>
<a href="{{ route('inventory.search') }}" class="btn btn-primary">Jan検索</a>

<br>
<br>

<form action="{{ route('inventory.search') }}" method="POST">
    @csrf
    <div>
        <label for="JAN">JANコード</label>
        <input type="text" name="JAN" id="JAN" value="{{ old('JAN') }}">
    </div>
    <button type="submit">登録</button>
</form>
</body>
</html>
