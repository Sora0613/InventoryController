@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">買い物リスト編集</div>

                    <div class="card-body">
                        @isset($list)
                            <form method="POST" action="{{ route('shoppinglist.update', $list->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="title" class="col-md-4 col-form-label text-md-right">タイトル</label>

                                    <div class="col-md-auto">
                                        <input id="title" type="text"
                                               class="form-control" name="title"
                                               value="{{ $list->title }}" autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="body" class="col-md-4 col-form-label text-md-right">内容</label>

                                    <div class="col-md-auto">
                                    <textarea id="body" type="text"
                                              class="form-control" name="body"
                                              required autocomplete="body">{{ $list->content }}</textarea>
                                    </div>
                                </div>

                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        編集
                                    </button>
                                </div>
                            </form>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
