@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">在庫一覧</div>

                    <div class="card-body">
                        @isset($message)
                            <div class="alert alert-success" role="alert">
                                {{ $message }}
                            </div>
                            <br>
                        @endisset

                        @isset($inventories)
                            @if(count($inventories) === 0)
                                <div class="alert alert-warning" role="alert">
                                    在庫情報がありません - <a href="{{ route('inventory.create') }}" class="alert-link">在庫登録へ</a>
                                </div>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">商品名</th>
                                        <th scope="col">JANコード</th>
                                        <th scope="col">数</th>
                                        <th scope="col" class="text-nowrap">価格</th>
                                        <th scope="col">賞味期限</th>
                                        <th scope="col">作成者</th>
                                        <th scope="col">更新日時</th>
                                        <th scope="col">編集</th>
                                        <th scope="col">削除</th>
                                    </tr>
                                    </thead>
                                    @foreach($inventories as $inventory)
                                        <tbody>
                                        <tr>
                                            <td>{{ $inventory->name }}</td>
                                            <td>{{ $inventory->JAN ?? "未設定" }}</td>


                                            <td class="text-nowrap">
                                                <form action="{{ route('inventory.update', $inventory->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    {{ $inventory->quantity ?? '1' }}
                                                    <br>
                                                    <button
                                                        class="btn btn-outline-{{ Auth::check() && Auth::user()->isDarkMode() ? 'light' : 'dark' }}"
                                                        name="reduce-btn" type="submit">-
                                                    </button>
                                                    <button
                                                        class="btn btn-outline-{{ Auth::check() && Auth::user()->isDarkMode() ? 'light' : 'dark' }}"
                                                        name="add-btn" type="submit">+
                                                    </button>
                                                </form>
                                            </td>


                                            <td>{{ $inventory->price ?? '未設定' }}</td>
                                            <td>
                                                @if($inventory->expiration_date)
                                                    @if($inventory->expiration_date < date('Y-m-d'))
                                                        <span style="color: red;">賞味期限切れ：{{ $inventory->expiration_date }}</span>
                                                    @elseif($inventory->expiration_date === date('Y-m-d'))
                                                        <span style="color: red;">本日賞味期限</span>
                                                    @elseif($inventory->expiration_date < date('Y-m-d', strtotime('+3 day')))
                                                        <span style="color: red;">賞味期限まであと{{ (strtotime($inventory->expiration_date) - strtotime(date('Y-m-d'))) / 86400 }}日 ( {{ $inventory->expiration_date }}</span>
                                                    @else
                                                        {{ $inventory->expiration_date }}
                                                    @endif
                                                @else
                                                    未設定
                                                @endif
                                            </td>
                                            <td>{{ $inventory->user_name }}</td>
                                            <td>{{ $inventory->updated_at }}</td>
                                            <td class="text-nowrap">
                                                <a class="btn btn-outline-primary"
                                                   href="{{ route('inventory.edit', $inventory->id) }}">編集</a>
                                            </td>
                                            <td class="text-nowrap">
                                                <form action="{{ route('inventory.destroy', $inventory->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger" type="submit">削除</button>
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    @endforeach
                                </table>
                            @endif
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

