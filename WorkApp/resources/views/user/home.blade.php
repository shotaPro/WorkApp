@php
    use App\Models\User;
    use App\Models\W_category;

    $user_id = Auth::user()->id;
    $profile_data = User::find($user_id);

    $category_info = W_category::with(['getSubcategory.category'])->get();

@endphp

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
        .news span {
            position: absolute;
            /* 相対位置に指定 */
            top: 2px;
            /* 表示位置を上から-10pxの位置にする */
            left: calc(95% - 10px);
            /* 表示位置を右から内側に10pxの位置 */
            color: #FFF;
            /* 文字色を白に指定 */
            font-weight: bold;
            /* 太文字にする */
            line-height: 20px;
            /* 行の高さを指定 */
            text-align: center;
            /* 文字を中央揃えにする */
            background: red;
            /* 背景色をオレンジに指定 */
            border-radius: 10px;
            /* line-heightの半分の角丸を指定 */
            min-width: 20px;
            /* 最低幅を指定 */
            padding: 0 3px;
            /* 左右に少しだけ余白を設定 */
            box-sizing: border-box;
            /* 計算しやすいように */
        }
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
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        プロフィール
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item"
                                                href="{{ url('/user_profile_page', $user_id) }}">自分のプロフィールを確認する</a></li>
                                        @if ($profile_data['user_name'] != '')
                                            <li><a class="dropdown-item"
                                                    href="{{ url('/user_profile_edit_page', $profile_data['id']) }}">編集する</a>
                                            </li>
                                        @else
                                            <li><a class="dropdown-item"
                                                    href="{{ url('/user_profile_register_page') }}">登録する</a></li>
                                        @endif
                                    </ul>
                                </li>
                                <a class="nav-link" href="{{ url('recruit_work_page') }}"role="button">
                                    募集中の仕事を探す
                                </a>
                                <a class="nav-link" href="{{ url('worker_list_page') }}"role="button">
                                    新しいワーカーを探す
                                </a>
                                <a class="nav-link news" role="button" href="{{ url('message_list_page') }}">通知
                                    @if ($notification_info->isNotEmpty())
                                        <span class="notice">{{ count($notification_info) }}</span>
                                    @endif
                                </a>
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


                    <div>

                    </div>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div id="receiver_menu" class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">気になる</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">相談</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="{{ url('contract_list_page') }}">契約一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">報酬</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">メッセージ</a>
                        </li>
                        <li class="nav-item">
                            <a id="receiver_btn" class="nav-link active" aria-current="page"
                                href="#">受注者メニュー</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div id="order_menu" style="display: none !important" class="collapse navbar-collapse"
                    id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="{{ url('order_work_page') }}">仕事を掲載</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="{{ url('work_management_page') }}">仕事管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">ワーカー管理</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">タイムシート</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">メッセージ</a>
                        </li>
                        <li class="nav-item">
                            <a id="order_btn" class="nav-link active" aria-current="page" href="#">発注者メニュー</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container-xxl position-relative bg-white d-flex p-0">

                <!-- Sidebar Start -->
                <div class="sidebar pe-4 pb-3">
                    <nav class="navbar bg-light navbar-light">
                        <a href="index.html" class="navbar-brand mx-4 mb-3">
                            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                        </a>
                        <div class="d-flex align-items-center ms-4 mb-4">
                            <div class="position-relative">
                                <img class="rounded-circle" src="img/user.jpg" alt=""
                                    style="width: 40px; height: 40px;">
                                <div
                                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                                </div>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Jhon Doe</h6>
                                <span>Admin</span>
                            </div>
                        </div>
                        <div class="navbar-nav w-100">
                            @foreach ($category_info as $info)
                                @php
                                    // dd($info);
                                @endphp
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                            class="far fa-file-alt me-2"></i>{{ $info->category_name }}</a>
                                    <div class="dropdown-menu bg-transparent border-0">
                                        @foreach ($info->getSubcategory as $sub)
                                            <a href="{{ url('subcategory_page', $sub->id) }}"
                                                class="dropdown-item">{{ $sub->subcategory_name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </nav>
                </div>
                <!-- Sidebar End -->
                <div>
                    <h2>ニュース</h2>
                    @foreach ($admin_news_info as $info)
                        <div style="border: 1px solid black; width: 500px" class="text-center mx-auto">
                            <p>お知らせ: {{ $info->admin_news_text }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
        @foreach ($work_info as $info)
            <div class="card" style="margin-top:20px;">
                <div style="display: flex">
                    <img style="height: 40px; width: 40px;" src="/profile_picture/" class="" alt="...">
                    <h4 style="margin-left: 20px"></h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $info->work_title }}</h5>
                    <p class="card-text">{{ $info->work_contents }}</p>
                    <h5>報酬額</h5>
                    <p class="card-text">{{ $info->rewards }}</p>
                    <h5>応募数</h5>
                    <p class="card-text">
                        @if ($info->apply_number == null)
                            0
                        @else
                            {{ $info->apply_number }}
                        @endif
                    </p>
                    <a href="{{ url('work_detail_info_page', $info->id) }}" class="btn btn-primary">詳細を見る</a>
                </div>
            </div>
            <br>
        @endforeach

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="admin/lib/chart/chart.min.js"></script>
        <script src="admin/lib/easing/easing.min.js"></script>
        <script src="admin/lib/waypoints/waypoints.min.js"></script>
        <script src="admin/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="admin/lib/tempusdominus/js/moment.min.js"></script>
        <script src="admin/lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="admin/js/main.js"></script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

        <script>
            const receiver_btn = document.getElementById('receiver_btn');
            const order_btn = document.getElementById('order_btn');
            const receiverMenu = document.getElementById('receiver_menu');
            const orderMenu = document.getElementById('order_menu');

            console.log(receiver_btn, order_btn, receiverMenu, orderMenu);

            receiver_btn.addEventListener('click', function(e) {

                e.preventDefault();
                receiverMenu.style.cssText = 'display: none !important';

                orderMenu.style.display = null;
                orderMenu.style.display = 'block';


            })

            order_btn.addEventListener('click', function(e) {

                e.preventDefault();
                orderMenu.style.cssText = 'display: none !important';

                receiverMenu.style.display = null;
                receiverMenu.style.display = 'block';

            })
        </script>

</body>

</html>
