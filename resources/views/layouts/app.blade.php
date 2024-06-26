<!doctype html>
<html lang="ja" data-bs-theme="{{ Auth::check() && Auth::user()->isDarkMode() ? 'dark' : 'light' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>


    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>

    <style>
        .image-button {
            background-image: url('storage/btn_login_base.png');
            width: 142px; /* 画像の幅に合わせて調整 */
            height: 40px; /* 画像の高さに合わせて調整 */
            border: none;
            cursor: pointer;
            background-color: transparent;
        }

        .image-button:hover {
            background-image: url('storage/btn_login_hover.png');
        }

        .image-button:active {
            background-image: url('storage/btn_login_press.png');
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md {{ Auth::check() && Auth::user()->isDarkMode() ? 'shadow' : 'shadow-sm' }}"
         data-bs-theme="{{ Auth::check() && Auth::user()->isDarkMode() ? 'dark' : 'light' }}">

        <div class="container">
            <a class="navbar-brand" href="/">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @guest
                @else
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-item nav-link {{ Route::is('inventory.index') ? 'active' : '' }}"
                               href="{{ route('inventory.index') }}">在庫一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link {{ Route::is('inventory.create') ? 'active' : '' }}"
                               href="{{ route('inventory.create') }}">在庫登録</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link {{ Route::is('inventory.searchJan') ? 'active' : '' }}"
                               href="{{ route('inventory.searchJan') }}">JAN検索</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link {{ Route::is('collaborators.index') ? 'active' : '' }}"
                               href="{{ route('collaborators.index') }}">共有管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link {{ Route::is('shoppinglist.index') ? 'active' : '' }}"
                               href="{{ route('shoppinglist.index') }}">買い物リスト</a>
                        </li>
                    </ul>
                @endguest

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user.edit') }}">プロフィール</a>
                                @if(!Auth::user()->isLineExists())
                                    <a class="dropdown-item" href="{{ route('line.index') }}">LINE認証</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('line.index') }}">LINE設定</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <div class="dropdown-divider"></div>
                                <p class="dropdown-item disabled">ダークモード</p>
                                <div class="form-check form-switch mx-3 mb-2">
                                    <form id="darkModeForm" action="{{ route('toggleDarkMode') }}" method="POST"
                                          class="mx-3 mb-2">
                                        @csrf
                                        <input type="hidden" name="dark_mode"
                                               value="{{ Auth::user()->isDarkMode() ? 'false' : 'true' }}">
                                        <label for="darkModeSwitch" class="btn btn-link form-check-label">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="darkModeSwitch"
                                                   onchange="darkModeForm.submit()" {{ Auth::user()->isDarkMode() ? 'checked' : '' }}>
                                        </label>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
