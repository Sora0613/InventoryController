@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="card-body card-body d-flex flex-column align-items-center justify-content-center">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="card-body card-body d-flex flex-column align-items-center justify-content-center">
                <a href="{{ route('shoppinglist.create') }}" class="btn btn-primary">買い物リスト作成</a>
            </div>

            @isset($usersLists)
                @foreach($usersLists as $list)
                    <div class="col-md-4">

                        <div class="card sticky-note">
                            <div class="card-body">
                                <a href="{{ route('shoppinglist.show', $list->id) }}" class="sticky-note">
                                    <h2>{{ $list->title }}</h2>
                                    <p>{{ $list->content }}</p>
                                </a>

                                <!-- Dropdown Button -->
                                <div class="dropdown position-absolute bottom-0 end-0">
                                    <button class="btn btn-outline-secondary" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        ...
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                               data-bs-target="#deleteConfirmationModal{{ $list->id }}">削除</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 削除確認 -->
                        <div class="modal fade" id="deleteConfirmationModal{{ $list->id }}" tabindex="-1"
                             aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteConfirmationModalLabel">削除の確認</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        本当に削除しますか？
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            キャンセル
                                        </button>
                                        <form method="POST" action="{{ route('shoppinglist.destroy', $list->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">削除</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset

        </div>
    </div>

    <style>
        .sticky-note {
            text-decoration: none;
            color: inherit;
            margin-bottom: 20px;
            display: block;
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
            box-shadow: 0 0 10px rgb(0, 0, 0);
        }

    </style>

@endsection
