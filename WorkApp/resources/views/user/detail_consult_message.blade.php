@php
    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\Auth;

    use App\Models\User;
    use App\Models\W_category;
    use Illuminate\Http\Request;

    $user_id = null;
    $user_id = Auth::user()->id;
    $profile_data = User::find($user_id);

    $category_info = W_category::with(['getSubcategory.category'])->get();

    if (isset($job_recruit_info->receiver_person_id)) {
        $applicant_user_info = $job_recruit_info->receiver_person_id;
        $applicant_user_info = explode(',', $applicant_user_info);
    } else {
        $applicant_user_info = null;
    }

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
        .stars span{
  display: flex;               /* 要素をフレックスボックスにする */
  flex-direction: row-reverse; /* 星を逆順に並べる */
  justify-content: flex-end;   /* 逆順なので、左寄せにする */
}

.stars input[type='radio']{
  display: none;               /* デフォルトのラジオボタンを非表示にする */
}

.stars label{
  color: #D2D2D2;              /* 未選択の星をグレー色に指定 */
  font-size: 30px;             /* 星の大きさを30pxに指定 */
  padding: 0 5px;              /* 左右の余白を5pxに指定 */
  cursor: pointer;             /* カーソルが上に乗ったときに指の形にする */
}

.stars label:hover,
.stars label:hover ~ label,
.stars input[type='radio']:checked ~ label{
  color: #F8C601;              /* 選択された星以降をすべて黄色にする */
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
                            <a class="nav-link active" aria-current="page"
                                href="{{ url('message_list_page') }}">Home</a>
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
            <div class="container-xxl position-relative bg-white p-0">

                @if ($job_recruit_info != null)
                    @if ($job_recruit_info->pay_flg == 1)
                        <div class="text-center">
                            <a data-bs-toggle="modal" href="#exampleModalToggle" role="button"
                                class="btn btn-warning">{{ $sender_info->user_name }}さんに評価をつけよう</a>
                        </div>
                        <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                            aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalToggleLabel">{{ $sender_info->user_name }}さんに評価をつけてください。</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">X</button>
                                    </div>
                                    <form action="{{ url('select_reputation_star') }}" method="GET">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="stars">
                                            <span>
                                                <input id="review01" type="radio" name="review"value="5"><label for="review01">★</label>
                                                <input id="review02" type="radio" name="review"value="4"><label for="review02">★</label>
                                                <input id="review03" type="radio" name="review"value="3"><label for="review03">★</label>
                                                <input id="review04" type="radio" name="review"value="2"><label for="review04">★</label>
                                                <input id="review05" type="radio" name="review"value="1"><label for="review05">★</label>
                                            </span>
                                            </div>
                                            <div>感想:<br><textarea name="reputation_message" type="text"></textarea></div>
                                            <input name="reputation_to_id" type="hidden" value="{{ $sender_info->user_id }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="submit">送信する</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <h1 class="text-center">メッセージ内容</h1>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                            x
                        </button>
                        {{ session()->get('message') }}
                    </div>
                @endif

                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="color: red">※{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <!-- Content Start -->
                <div class="content mx-auto">
                    <!-- Sale & Revenue Start -->
                    {{-- 送信者の情報 --}}
                    <div class="container-fluid ml-6">
                        @if ($job_recruit_info != null)
                            <div class="mx-auto  card" style="width: 18rem; margin-bottom: 20px">
                                <div class="card-body">
                                    <h5 class="card-title"></h5>{{ $job_recruit_info->work_title }}
                                    <p class="card-text">{{ $job_recruit_info->work_contents }}</p>
                                    <h5>報酬額</h5>
                                    <p class="card-text">{{ number_format($job_recruit_info->rewards) }}円</p>
                                    <h5>応募数</h5>
                                    <p class="card-text">{{ $job_recruit_info->apply_number }}人</p>
                                </div>
                            </div>
                        @endif
                        <div class="mx-auto  card" style="width: 18rem; margin-bottom: 20px">
                            <div style="display: flex">
                                <img style="height: 40px; width: 40px;"
                                    src="/profile_picture/{{ $sender_info->image }}" class="" alt="...">
                                <h4 style="margin-left: 20px">{{ $sender_info->user_name }}</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $sender_info->consult_message }}</p>
                            </div>
                        </div>
                        {{-- 返信情報 --}}
                        @if ($reply_message != null)
                            @foreach ($reply_message as $info)
                                <div class="mx-auto  card" style="width: 18rem; margin-bottom: 20px">
                                    <div style="display: flex">
                                        <img style="height: 40px; width: 40px;"
                                            src="/profile_picture/{{ $info->image }}" class=""
                                            alt="...">
                                        <h4 style="margin-left: 20px">{{ $info->user_name }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ $info->reply_message }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="text-center mt-4">
                            <form action="{{ url('reply_consult_message', $sender_info->id) }}" method="POST">
                                @csrf
                                <textarea name="reply_message" type="text" style="display: block; margin-left:auto; margin-right: auto; width:20%"
                                    placeholder="ここにメッセージを入力">

                            </textarea>
                                <input type="number" name="messageFrom_user_id" style="display:none"
                                    value="{{ $sender_info->receiver_id }}">
                                <button class="btn btn-primary" type="submit">この内容で返信する</button>
                            </form>
                            {{-- 自分が提示した仕事に対して応募のメッセージがあった場合、以下の仕事依頼確定ボタンを表示 --}}
                            @if ($sender_info->task_id != null)
                                @if ($user_id == $job_recruit_info->order_person_id)
                                    <form action="{{ url('choose_applicant') }}" method="POST">
                                        @csrf
                                        <input name="applicant_id" type="hidden"
                                            value="{{ $sender_info->sender_id }}">
                                        <input name="work_id" type="hidden" value="{{ $job_recruit_info->id }}">
                                        @if (in_array($sender_info->sender_id, $applicant_user_info))
                                            <a href="#" class="btn btn-light">確定済み</a>
                                        @else
                                            <button class="btn btn-warning" type="submit">この人に仕事の依頼を確定する</button>
                                        @endif
                                    </form>
                                @endif
                            @endif
                        </div>

                    </div>
                    <!-- Sale & Revenue End -->

                </div>
                <!-- Content End -->


            </div>

            <!-- JavaScript Libraries -->
            <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="admin/lib/chart/chart.min.js"></script>
            <script src="admin/lib/easing/easing.min.js"></script>
            <script src="admin/lib/waypoints/waypoints.min.js"></script>
            <script src="admin/lib/owlcarousel/owl.carousel.min.js"></script>
            <script src="admin/lib/tempusdominus/js/moment.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

            <!-- Template Javascript -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
            </script>

            <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="admin/lib/chart/chart.min.js"></script>


</body>

</html>
