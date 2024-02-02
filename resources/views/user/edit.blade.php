@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ユーザー情報編集</div>

                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-light" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        @auth
                            <form method="POST" action="{{ route('user.update', ['id' => $user->id]) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                               class="form-control @error('name') is-invalid @enderror" name="name"
                                               value="{{ $user->name }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email"
                                           class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="{{ $user->email }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary">更新</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
