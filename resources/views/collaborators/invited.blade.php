@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">在庫登録</div>
                    <div class="card-body">
                        @isset($message)
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @endisset
                        @isset($success_message)
                            <div class="alert alert-success" role="alert">
                                {{ $success_message }}
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

