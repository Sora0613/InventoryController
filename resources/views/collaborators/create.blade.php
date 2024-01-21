@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">共有管理</div>

                    <div class="card-body">
                        @isset($searchResults)
                            <div class="alert alert-info" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                {{ $searchResults }}
                            </div>
                            <br>
                        @endisset

                        <form action="{{ route('collaborators.search') }}" method="GET">
                            @csrf
                            <div class="form-group">
                                <label for="email">共有者メールアドレス</label>
                                <input class="form-control" type="email" name="email" placeholder="user_email@email.com" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">検索</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
