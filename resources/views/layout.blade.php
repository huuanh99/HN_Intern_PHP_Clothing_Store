<!DOCTYPE HTML>
<head>
    <title>{{ config('const.websitename') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset = utf-8" />
    <meta name="viewport" content="width = device-width, initial-scale = 1, maximum-scale = 1">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('css/style1.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('css/comment.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet" type="text/css" media="all" />
    <script src="{{ asset('js/jquerymain.js') }}"></script>
    <script src="{{ asset('js/script.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-1.7.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/nav.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/move-top.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/easing.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/nav-hover.js') }}"></script>
</head>

<body>
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2">
                    <div class="dropdown">
                        <button class="dropbtn">{{ __('changeLanguage') }}</button>
                        <div class="dropdown-content">
                            <a href="{{ route('changeLanguage',['language' => 'en']) }}">{{ __('english') }}</a>
                            <a href="{{ route('changeLanguage',['language' => 'vi']) }}">{{ __('vietnamese') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <nav class="header__menu">
                        <ul>
                            <li><a href="{{ route('index') }}">{{ __('home') }}</a></li>
                            @if (Auth::user() != null)
                                <li><a href='{{ route('profile') }}'>{{ __('profile') }}</a></li>
                                <li><a href='{{ route('order') }}'>{{ __('orders') }}</a></li>
                                <li><a href="{{ route('showChangePasswordView') }}">{{ __('password') }}</a></li>
                            @endif
                            <div class="dropdown">
                                <li><a>{{ __('categories') }}</a></li>
                                <div class="dropdown-content">
                                    @foreach ($categories as $item)
                                        @if ($item->parent_id == null)
                                            <a href="{{ route('productbycat',['id' => $item->id]) }}">{{ $item->name }}</a>
                                        @else
                                            <a href="{{ route('productbycat',['id' => $item->id]) }}">--{{ $item->name }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="dropdown">
                                <li><a>{{ __('price') }}</a></li>
                                <div class="dropdown-content">
                                    <a href="{{ route('productbyprice',['price'  => 100000]) }}">{{ __('lower200') }}</a>
                                    <a href="{{ route('productbyprice',['price'  => 300000]) }}">{{ __('200-500') }}</a>
                                    <a href="{{ route('productbyprice',['price'  => 600000]) }}">{{ __('higher500') }}</a>
                                </div>
                            </div>
                        </ul>
                    </nav>
                    <div class="search_box">
                        <form action="{{ route('search') }}" method="POST">
                            @csrf
                            <input type="text" name="keyword" placeholder="{{ __('keyword') }}">
                            <input type="submit" value="{{ __('search') }}">
                        </form>
                    </div>
                </div>
                <div class="col-3">
                    <div class="header__right">
                        <div class="header__right__auth">
                            @if (Auth::user() == null)
                                <a href="{{ route('login') }}">{{ __('login') }}</a>
                                <a href="{{ route('register') }}">{{ __('register') }}</a>
                            @else
                                <a href='{{ route('logout') }}'>{{ __('logout') }}</a>
                            @endif
                        </div>
                        <ul class="header__right__widget">
                            <li><a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i>
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="wrap">
        @yield('content')
    </div>
</body>

</html>
