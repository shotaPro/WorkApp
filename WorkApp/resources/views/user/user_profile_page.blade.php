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
        .rating {
            position: relative;
            z-index: 0;
            display: inline-block;
            white-space: nowrap;
            color: #CCCCCC;
            /* グレーカラー 自由に設定化 */
            /*font-size: 30px; フォントサイズ 自由に設定化 */
        }

        .rating:before,
        .rating:after {
            content: '★★★★★';
        }

        .rating:after {
            position: absolute;
            z-index: 1;
            top: 0;
            left: 0;
            overflow: hidden;
            white-space: nowrap;
            color: #ffcf32;
            /* イエローカラー 自由に設定化 */
        }

        .rating[data-rate="5"]:after {
            width: 100%;
        }

        /* 星5 */
        .rating[data-rate="4.5"]:after {
            width: 90%;
        }

        /* 星4.5 */
        .rating[data-rate="4"]:after {
            width: 80%;
        }

        /* 星4 */
        .rating[data-rate="3.5"]:after {
            width: 70%;
        }

        /* 星3.5 */
        .rating[data-rate="3"]:after {
            width: 60%;
        }

        /* 星3 */
        .rating[data-rate="2.5"]:after {
            width: 50%;
        }

        /* 星2.5 */
        .rating[data-rate="2"]:after {
            width: 40%;
        }

        /* 星2 */
        .rating[data-rate="1.5"]:after {
            width: 30%;
        }

        /* 星1.5 */
        .rating[data-rate="1"]:after {
            width: 20%;
        }

        /* 星1 */
        .rating[data-rate="0.5"]:after {
            width: 10%;
        }

        /* 星0.5 */
        .rating[data-rate="0"]:after {
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
                <h2 class="text-center">プロフィール画面</h2>
                <section style="background-color: #eee;">
                    <div class="container py-5">

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <img src="/profile_picture/{{ $profile_data['image'] }}"
                                            class="rounded-circle img-fluid" style="width: 150px;">
                                        <h5 class="my-3">{{ $profile_data['user_name'] }}</h5>
                                        <p class="text-muted mb-1">未設定</p>
                                        <p class="text-muted mb-4">未設定</p>
                                        <div class="d-flex justify-content-center mb-2">
                                            <button type="button" class="btn btn-primary">Follow</button>
                                            <button type="button"
                                                class="btn btn-outline-primary ms-1">Message</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">ユーザー名</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $profile_data['user_name'] }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">プロフィール文</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $profile_data['profile_text'] }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">スキル</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{ $profile_data['skill'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="text-center">
                    @if (isset($total_reputation_score))
                    <h5>評価</h5>
                    <p>総合評価:{{ $total_reputation_score }}</p>
                        @foreach ($reputation_by_userData as $data)
                            @foreach ($data as $d)
                                <div class="card mx-auto" style="width: 18rem;">
                                    <img style="height: 40px; width: 40px;"
                                        src="/profile_picture/{{ $d->image }}" class="card-img-top"
                                        alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">評価:{{ $d->reputation_score }}
                                            @if ($d->reputation_score == 5)
                                                <p><span class="rating" data-rate="5"></span> 星5</p>
                                            @elseif($d->reputation_score == 4)
                                                <p><span class="rating" data-rate="4"></span> 星4</p>
                                            @elseif($d->reputation_score == 3)
                                                <p><span class="rating" data-rate="3"></span> 星3</p>
                                            @elseif($d->reputation_score == 2)
                                                <p><span class="rating" data-rate="2"></span> 星2</p>
                                            @elseif($d->reputation_score == 1)
                                                <p><span class="rating" data-rate="1"></span> 星1</p>
                                            @else
                                                <p><span class="rating" data-rate="0"></span> 星0</p>
                                            @endif
                                        </h5>
                                        <p class="card-text">{{ $d->reputation_message }}</p>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>

</html>
