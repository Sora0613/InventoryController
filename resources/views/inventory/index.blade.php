<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>在庫一覧</title>
</head>

<body>
    <h1>在庫一覧</h1>
    <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
    <a href="{{ route('inventory.index') }}" class="btn btn-primary">在庫一覧</a>
    <a href="{{ route('inventory.create') }}" class="btn btn-primary">在庫登録</a>
    <a href="{{ route('inventory.search') }}" class="btn btn-primary">Jan検索</a>
    <br>
    <br>

    @isset($inventories)
        <table border="1">
            <tr>
                <th>商品名</th>
                <th>JANコード</th>
                <th>価格</th>
                <th>更新日時</th>
                <th>編集</th>
                <th>削除</th>
            </tr>
            @foreach ($inventories as $inventory)
                <tr>
                    <td>{{ $inventory->name }}</td>
                    <td>{{ $inventory->JAN }}</td>
                    <td>{{ $inventory->price ?? '' }}</td>
                    <td>{{ $inventory->updated_at }}</td>
                    <td>
                        <a href="{{ route('inventory.edit', $inventory->id) }}">編集</a>
                    </td>
                    <td>
                        <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endisset
</body>
</html>
