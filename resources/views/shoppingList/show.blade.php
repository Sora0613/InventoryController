@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">リスト詳細</div>

                    <div class="card-body">
                        @isset($list)
                            <h2>{{ $list->title }}</h2>
                            <br>
                            <div class="border p-3 rounded">
                                <p>{{ $list->content }}</p>
                            </div>
                            <br>
                            <a href="{{ route('shoppinglist.edit', $list->id) }}" class="btn btn-primary">編集</a>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
