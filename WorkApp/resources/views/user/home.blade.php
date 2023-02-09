@php
    use App\Models\User;
    use App\Models\W_category;

    $user_id = null;
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
  position: absolute;     /* 相対位置に指定 */
  top: 2px;             /* 表示位置を上から-10pxの位置にする */
  left: calc(95% - 10px);/* 表示位置を右から内側に10pxの位置 */
  color: #FFF;            /* 文字色を白に指定 */
  font-weight: bold;      /* 太文字にする */
  line-height: 20px;      /* 行の高さを指定 */
  text-align: center;     /* 文字を中央揃えにする */
  background: red;    /* 背景色をオレンジに指定 */
  border-radius: 10px;    /* line-heightの半分の角丸を指定 */
  min-width: 20px;        /* 最低幅を指定 */
  padding: 0 3px;         /* 左右に少しだけ余白を設定 */
  box-sizing: border-box; /* 計算しやすいように */
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
                                                href="{{ url('/user_profile_page') }}">自分のプロフィールを確認する</a></li>
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
                                    @if($notification_info->isNotEmpty())
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
                            <a class="nav-link active" aria-current="page" href="#">契約一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">報酬</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">メッセージ</a>
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
                            <a class="nav-link active" aria-current="page" href="#">仕事管理</a>
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
                <!-- Spinner Start -->
                <div id="spinner"
                    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->


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


                <!-- Content Start -->
                <div class="content mt-4">
                    <!-- Navbar Start -->
                    <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                        <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                            <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                        </a>
                        <a href="#" class="sidebar-toggler flex-shrink-0">
                            <i class="fa fa-bars"></i>
                        </a>
                        <form class="d-none d-md-flex ms-4">
                            <input class="form-control border-0" type="search" placeholder="Search">
                        </form>
                        <div class="navbar-nav align-items-center ms-auto">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fa fa-envelope me-lg-2"></i>
                                    <span class="d-none d-lg-inline-flex">Message</span>
                                </a>
                                <div
                                    class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                                    <a href="#" class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle" src="img/user.jpg" alt=""
                                                style="width: 40px; height: 40px;">
                                            <div class="ms-2">
                                                <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                                <small>15 minutes ago</small>
                                            </div>
                                        </div>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="#" class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle" src="img/user.jpg" alt=""
                                                style="width: 40px; height: 40px;">
                                            <div class="ms-2">
                                                <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                                <small>15 minutes ago</small>
                                            </div>
                                        </div>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="#" class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle" src="img/user.jpg" alt=""
                                                style="width: 40px; height: 40px;">
                                            <div class="ms-2">
                                                <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                                <small>15 minutes ago</small>
                                            </div>
                                        </div>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="#" class="dropdown-item text-center">See all message</a>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fa fa-bell me-lg-2"></i>
                                    <span class="d-none d-lg-inline-flex">Notificatin</span>
                                </a>
                                <div
                                    class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                                    <a href="#" class="dropdown-item">
                                        <h6 class="fw-normal mb-0">Profile updated</h6>
                                        <small>15 minutes ago</small>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="#" class="dropdown-item">
                                        <h6 class="fw-normal mb-0">New user added</h6>
                                        <small>15 minutes ago</small>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="#" class="dropdown-item">
                                        <h6 class="fw-normal mb-0">Password changed</h6>
                                        <small>15 minutes ago</small>
                                    </a>
                                    <hr class="dropdown-divider">
                                    <a href="#" class="dropdown-item text-center">See all notifications</a>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                    <img class="rounded-circle me-lg-2" src="img/user.jpg" alt=""
                                        style="width: 40px; height: 40px;">
                                    <span class="d-none d-lg-inline-flex">John Doe</span>
                                </a>
                                <div
                                    class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                                    <a href="#" class="dropdown-item">My Profile</a>
                                    <a href="#" class="dropdown-item">Settings</a>
                                    <a href="#" class="dropdown-item">Log Out</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <!-- Navbar End -->


                    <!-- Sale & Revenue Start -->
                    <div class="container-fluid pt-4 px-4">
                        <div class="row g-4">
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Today Sale</p>
                                        <h6 class="mb-0">$1234</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Total Sale</p>
                                        <h6 class="mb-0">$1234</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Today Revenue</p>
                                        <h6 class="mb-0">$1234</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-chart-pie fa-3x text-primary"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Total Revenue</p>
                                        <h6 class="mb-0">$1234</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sale & Revenue End -->


                    <!-- Sales Chart Start -->
                    <div class="container-fluid pt-4 px-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-xl-6">
                                <div class="bg-light text-center rounded p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <h6 class="mb-0">Worldwide Sales</h6>
                                        <a href="">Show All</a>
                                    </div>
                                    <canvas id="worldwide-sales"></canvas>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-6">
                                <div class="bg-light text-center rounded p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <h6 class="mb-0">Salse & Revenue</h6>
                                        <a href="">Show All</a>
                                    </div>
                                    <canvas id="salse-revenue"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sales Chart End -->


                    <!-- Recent Sales Start -->
                    <div class="container-fluid pt-4 px-4">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Recent Salse</h6>
                                <a href="">Show All</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-start align-middle table-bordered table-hover mb-0">
                                    <thead>
                                        <tr class="text-dark">
                                            <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Invoice</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox"></td>
                                            <td>01 Jan 2045</td>
                                            <td>INV-0123</td>
                                            <td>Jhon Doe</td>
                                            <td>$123</td>
                                            <td>Paid</td>
                                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox"></td>
                                            <td>01 Jan 2045</td>
                                            <td>INV-0123</td>
                                            <td>Jhon Doe</td>
                                            <td>$123</td>
                                            <td>Paid</td>
                                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox"></td>
                                            <td>01 Jan 2045</td>
                                            <td>INV-0123</td>
                                            <td>Jhon Doe</td>
                                            <td>$123</td>
                                            <td>Paid</td>
                                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox"></td>
                                            <td>01 Jan 2045</td>
                                            <td>INV-0123</td>
                                            <td>Jhon Doe</td>
                                            <td>$123</td>
                                            <td>Paid</td>
                                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox"></td>
                                            <td>01 Jan 2045</td>
                                            <td>INV-0123</td>
                                            <td>Jhon Doe</td>
                                            <td>$123</td>
                                            <td>Paid</td>
                                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Recent Sales End -->


                    <!-- Widgets Start -->
                    <div class="container-fluid pt-4 px-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-md-6 col-xl-4">
                                <div class="h-100 bg-light rounded p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="mb-0">Messages</h6>
                                        <a href="">Show All</a>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-3">
                                        <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt=""
                                            style="width: 40px; height: 40px;">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-0">Jhon Doe</h6>
                                                <small>15 minutes ago</small>
                                            </div>
                                            <span>Short message goes here...</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-3">
                                        <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt=""
                                            style="width: 40px; height: 40px;">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-0">Jhon Doe</h6>
                                                <small>15 minutes ago</small>
                                            </div>
                                            <span>Short message goes here...</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-3">
                                        <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt=""
                                            style="width: 40px; height: 40px;">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-0">Jhon Doe</h6>
                                                <small>15 minutes ago</small>
                                            </div>
                                            <span>Short message goes here...</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center pt-3">
                                        <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt=""
                                            style="width: 40px; height: 40px;">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-0">Jhon Doe</h6>
                                                <small>15 minutes ago</small>
                                            </div>
                                            <span>Short message goes here...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-4">
                                <div class="h-100 bg-light rounded p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <h6 class="mb-0">Calender</h6>
                                        <a href="">Show All</a>
                                    </div>
                                    <div id="calender"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-4">
                                <div class="h-100 bg-light rounded p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <h6 class="mb-0">To Do List</h6>
                                        <a href="">Show All</a>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <input class="form-control bg-transparent" type="text"
                                            placeholder="Enter task">
                                        <button type="button" class="btn btn-primary ms-2">Add</button>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-2">
                                        <input class="form-check-input m-0" type="checkbox">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 align-items-center justify-content-between">
                                                <span>Short task goes here...</span>
                                                <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-2">
                                        <input class="form-check-input m-0" type="checkbox">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 align-items-center justify-content-between">
                                                <span>Short task goes here...</span>
                                                <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-2">
                                        <input class="form-check-input m-0" type="checkbox" checked>
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 align-items-center justify-content-between">
                                                <span><del>Short task goes here...</del></span>
                                                <button class="btn btn-sm text-primary"><i
                                                        class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom py-2">
                                        <input class="form-check-input m-0" type="checkbox">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 align-items-center justify-content-between">
                                                <span>Short task goes here...</span>
                                                <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center pt-2">
                                        <input class="form-check-input m-0" type="checkbox">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 align-items-center justify-content-between">
                                                <span>Short task goes here...</span>
                                                <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Widgets End -->


                    <!-- Footer Start -->
                    <div class="container-fluid pt-4 px-4">
                        <div class="bg-light rounded-top p-4">
                            <div class="row">
                                <div class="col-12 col-sm-6 text-center text-sm-start">
                                    &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                                </div>
                                <div class="col-12 col-sm-6 text-center text-sm-end">
                                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                                    Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                                    </br>
                                    Distributed By <a class="border-bottom" href="https://themewagon.com"
                                        target="_blank">ThemeWagon</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Footer End -->
                </div>
                <!-- Content End -->


                <!-- Back to Top -->
                <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i
                        class="bi bi-arrow-up"></i></a>
            </div>

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
