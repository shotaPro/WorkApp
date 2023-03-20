<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <style>
        .star5_rating {
            position: relative;
            z-index: 0;
            display: inline-block;
            white-space: nowrap;
            color: #CCCCCC;
            /* グレーカラー 自由に設定化 */
            /*font-size: 30px; フォントサイズ 自由に設定化 */
        }

        .star5_rating:before,
        .star5_rating:after {
            content: '★★★★★';
        }

        .star5_rating:after {
            position: absolute;
            z-index: 1;
            top: 0;
            left: 0;
            overflow: hidden;
            white-space: nowrap;
            color: #ffcf32;
            /* イエローカラー 自由に設定化 */
        }

        .star5_rating[data-rate="5"]:after {
            width: 100%;
        }

        /* 星5 */
        .star5_rating[data-rate="4.5"]:after {
            width: 90%;
        }

        /* 星4.5 */
        .star5_rating[data-rate="4"]:after {
            width: 80%;
        }

        /* 星4 */
        .star5_rating[data-rate="3.5"]:after {
            width: 70%;
        }

        /* 星3.5 */
        .star5_rating[data-rate="3"]:after {
            width: 60%;
        }

        /* 星3 */
        .star5_rating[data-rate="2.5"]:after {
            width: 50%;
        }

        /* 星2.5 */
        .star5_rating[data-rate="2"]:after {
            width: 40%;
        }

        /* 星2 */
        .star5_rating[data-rate="1.5"]:after {
            width: 30%;
        }

        /* 星1.5 */
        .star5_rating[data-rate="1"]:after {
            width: 20%;
        }

        /* 星1 */
        .star5_rating[data-rate="0.5"]:after {
            width: 10%;
        }

        /* 星0.5 */
        .star5_rating[data-rate="0"]:after {
            width: 0%;
        }

        /* 星0 */
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container ">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ url('/home') }}">戻る</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Dropdown
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#" tabindex="-1"
                                        aria-disabled="true">Disabled</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

                        </ul>

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
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>

                </div>
            </div>
        </nav>
        <main class="py-4">
            <div>
                <h2 class="text-center">お知らせ作成画面</h2>
                <div class="text-center">
                    <form action="{{ 'admin_news_post' }}" method="POST">
                        @csrf
                        <textarea name="news_text" id="" cols="30" rows="10"></textarea><br>
                        <button type="submit">投稿する</button>
                    </form>
                </div>
                <h2 class="text-center mt-4">投稿したお知らせ内容一覧</h2>
                @foreach($all_news_info as $info)
                <div style="border: 1px solid black; width: 80%" class="text-center mx-auto">
                    <p>お知らせ: {{ $info->admin_news_text }}</p>
                    <div class="text-right">
                        <a class="btn btn-primary"  href="">編集する</a><br>
                        <a class="btn btn-danger" href="">削除する</a>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</body>

</html>
