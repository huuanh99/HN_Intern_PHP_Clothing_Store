<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/reset.css') }}" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/text.css') }}" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/grid.css') }}" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/layout.css') }}" media="screen" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/nav.css') }}" media="screen" />
    <link href="{{ asset('css/admin/table/demo_page.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/admin/jquery-1.6.4.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/admin/jquery-ui/jquery.ui.core.min.js') }}"></script>
    <script src="{{ asset('js/admin/jquery-ui/jquery.ui.widget.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/jquery-ui/jquery.ui.accordion.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/jquery-ui/jquery.effects.core.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/jquery-ui/jquery.effects.slide.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/jquery-ui/jquery.ui.mouse.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/jquery-ui/jquery.ui.sortable.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/table/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/table/table.js') }}"></script>
    <script src="{{ asset('js/admin/setup.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/pusher.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pusher.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/font-awesome.js') }}" type="text/javascript"></script>
</head>

<body>
    <div class="container_12">
        <div class="grid_12 header-repeat">
            <div id="branding">
                <div class="floatleft logo">
                    <div class="dropdown">
                        <button class="dropbtn">{{ __('changeLanguage') }}</button>
                        <div class="dropdown-content">
                            <a href="{{ route('changeLanguage',['language' => 'en']) }}">{{ __('english') }}</a>
                            <a href="{{ route('changeLanguage',['language' => 'vi']) }}">{{ __('vietnamese') }}</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="dropbtn notificationsToggle">
                            <i data-count="0" class="fa fa-bell"></i>
                            <span class="fa fa-comment"></span>
                            <span class="notif-count">0</span>
                        </button>
                        <div class="dropdown-content-notify notifications">
                            @foreach ($notifications as $item)
                                <a href="{{ route('showOrderPendingView') }}">{{ $item->content }}</a>
                            @endforeach                   
                        </div>
                    </div>
                </div>
                
                <div class="floatright">
                    <div class="floatleft marginleft10">
                        <ul class="inline-ul floatleft">
                            <li>{{ __('hello') }} {{ Auth::user()->name }}</li>
                            <li><form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                        </form></li>
                        </ul>
                    </div>
                </div>
                <div class="clear">
                </div>
            </div>
        </div>
        <div class="clear">
        </div>
     
        <div class="clear">
        </div>
        <div class="grid_2">
            <div class="box sidemenu">
                <div class="block" id="section-menu">
                    <ul class="section menu">

                        <li><a class="menuitem">{{ __('category') }}</a>
                            <ul class="submenu">
                                <li><a href="{{ route('catadd') }}">{{ __('addcategory') }}</a> </li>
                                <li><a href="{{ route('catlist') }}">{{ __('listcategory') }}</a> </li>
                            </ul>
                        </li>
                        <li><a class="menuitem">{{ __('product') }}</a>
                            <ul class="submenu">
                                <li><a href="{{ route('productadd') }}">{{ __('addproduct') }}</a> </li>
                                <li><a href="{{ route('productlist') }}">{{ __('listproduct') }}</a> </li>
                            </ul>
                        </li>
                        <li><a class="menuitem">{{ __('orders') }}</a>
                            <ul class="submenu">
                                <li><a href="{{ route('showOrderPendingView') }}">{{ __('approveorder') }}</a> </li>                     
                                <li><a href="{{ route('ordersuccess') }}">{{ __('orderapprove') }}</a> </li>
                                <li><a href="{{ route('orderfail') }}">{{ __('orderdeny') }}</a> </li>
                            </ul>
                        </li>
                        <li><a class="menuitem">{{ __('user') }}</a>
                            <ul class="submenu">
                                <li><a href="{{ route('userlist') }}">{{ __('listuser') }}</a></li>
                            </ul>
                        </li>
                        <li><a class="menuitem">{{ __('chart') }}</a>
                            <ul class="submenu">
                                <li><a href="{{ route('showOrderChart') }}">{{ __('orderchart') }}</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        @yield('content')
        <div class="clear">
        </div>
    </div>
    <div class="clear">
    </div>
 
</body>
</html>
