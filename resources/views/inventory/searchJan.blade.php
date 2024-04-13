@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">在庫登録</div>
                    <div class="card-body">
                        @isset($message)
                            <div class="alert alert-success" role="alert">
                                {{ $message }} - <a href="{{ route('inventory.index') }}"
                                                    class="alert-link">在庫一覧へ</a>
                            </div>
                            <br>
                        @endisset
                        <div class="form-group">
                            <form action="{{ route('inventory.searchJan') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="JAN">JANコード</label>
                                    <input class="form-control" type="text" name="JAN" id="JAN" value="{{ old('JAN') }}"
                                           required>
                                </div>
                                <br>
                                <button class="btn btn-primary" type="submit" name="register-directly">直接登録</button>
                                <button class="btn btn-primary" type="submit" name="register">登録</button>
                            </form>
                        </div>

                        @isset($terminal)
                            <br>
                            @if($terminal === 'pc')
                                <div class="form-group">
                                    <button id="start-camera" class="btn btn-primary">カメラで読み取る</button>
                                    <video id="barcode-scanner" autoplay style="display:none;"></video>
                                    <script src="{{ asset('js/barcode-scanner.js') }}"></script>
                                </div>
                            @endif
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
