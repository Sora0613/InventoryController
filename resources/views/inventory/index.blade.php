@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">在庫一覧</div>

                    <div class="card-body">
                        @isset($inventories)
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">商品名</th>
                                    <th scope="col">JANコード</th>
                                    <th scope="col">価格</th>
                                    <th scope="col">更新日時</th>
                                    <th scope="col">編集</th>
                                    <th scope="col">削除</th>
                                </tr>
                                </thead>
                                @foreach($inventories as $inventory)
                                    <tbody>
                                    <tr>
                                        <td>{{ $inventory->name }}</td>
                                        <td>{{ $inventory->JAN }}</td>
                                        <td>{{ $inventory->price ?? '' }}</td>
                                        <td>{{ $inventory->updated_at }}</td>
                                        <td>
                                            <a class="btn btn-outline-primary" href="{{ route('inventory.edit', $inventory->id) }}">編集</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" type="submit">削除</button>
                                            </form>
                                        </td>
                                    </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

