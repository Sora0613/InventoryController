@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">買い物リスト作成</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('shoppinglist.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="title" class="col-md-4 col-form-label text-md-right">タイトル</label>

                                <div class="col-md-auto">
                                    <input id="title" type="text"
                                           class="form-control" name="title"
                                           value="{{ old('title') }}" required autocomplete="title" autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="body" class="col-md-4 col-form-label text-md-right">内容</label>

                                <div class="col-md-auto">
                                    <textarea id="body" type="text"
                                              class="form-control" name="body"
                                              required autocomplete="body" autofocus>{{ old('body') }}</textarea>
                                </div>
                            </div>

                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
