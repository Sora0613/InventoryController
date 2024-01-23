@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card-body">
                <a href="#" class="btn btn-primary">買い物リスト作成</a>
            </div>

            <div class="col-md-4">
                <a href="#" class="sticky-note">
                    <div class="card">
                        <div class="card-body">
                            <h2>Sticky Note 1</h2>
                            <p>This is the content of the first sticky note.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="#" class="sticky-note">
                    <div class="card">
                        <div class="card-body">
                            <h2>Sticky Note 2</h2>
                            <p>This is the content of the second sticky note.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="#" class="sticky-note">
                    <div class="card">
                        <div class="card-body">
                            <h2>Sticky Note 3</h2>
                            <p>This is the content of the third sticky note.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- 以下、必要なだけ追加 -->
        </div>
    </div>

    <style>
        .sticky-note {
            text-decoration: none;
            color: inherit;
        }

        .sticky-note:hover {
            text-decoration: none;
            color: inherit;
        }

        .sticky-note .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: box-shadow 0.3s;
        }

        .sticky-note:hover .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>

@endsection
