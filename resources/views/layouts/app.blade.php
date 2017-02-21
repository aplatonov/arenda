<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Arenda') }}</title>

    <style>
        @font-face {
      font-family: 'Glyphicons Halflings';
      src: url('../fonts/glyphicons-halflings-regular.eot');
      src: url('../fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'), 
           url('../fonts/glyphicons-halflings-regular.woff') format('woff'), 
           url('../fonts/glyphicons-halflings-regular.ttf') format('truetype'), 
           url('../fonts/glyphicons-halflings-regular.svg#glyphicons-halflingsregular') format('svg');
    </style>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/datepicker.css" rel="stylesheet">
    <link href="/css/treeview.css" rel="stylesheet">
    <link href="/css/submenu.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/bootstrap-datepicker.js"></script>

    <script>
        window.Arenda = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @yield('scripts')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Arenda') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-left">
                        <!-- Authentication Links -->
                        @if (!Auth::guest() && Auth::user()->role_id == 1)
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('/') }}">Администрирование<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/admin/users') }}">Пользователи</a></li>
                                    <li><a href="{{ url('/admin/categories') }}">Категории</a></li>
                                </ul>
                            </li>    
                        @endif                      
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Вход</a></li>
                            <li><a href="{{ route('register') }}">Регистрация</a></li>
                        @else
                            <!--li><a href="{{ url('/requests') }}">Заявки</a></li-->
                            <li class="root">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('/requests') }}">Заявки<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/requests') }}">Все заявки</a></li>
                                    <li role="separator" class="divider"></li>
                                    @foreach($categories as $category)
                                        @if(count($category->childs))
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-toggle" href="{{ url('/requests/category/' . $category->id ) }}">{{ $category->name_cat }} <span class="badge">{{ count($category->requests) }}</span></a>
                                                @include('layouts.manageReqChildMenu',['childs' => $category->childs])
                                            </li>
                                        @else
                                            <li><a href="{{ url('/requests/category/' . $category->id ) }}">{{ $category->name_cat }} <span class="badge">{{ count($category->requests) }}</span></a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            <li class="root">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('/objects') }}">Объекты<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/objects') }}">Все объекты</a></li>
                                    <li role="separator" class="divider"></li>
                                    @foreach($categories as $category)
                                        @if(count($category->childs))
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-toggle" href="{{ url('/objects/category/' . $category->id ) }}">{{ $category->name_cat }} <span class="badge">{{ count($category->objects) }}</span></a>
                                                @include('layouts.manageObjChildMenu',['childs' => $category->childs])
                                            </li>
                                        @else
                                            <li><a href="{{ url('/objects/category/' . $category->id ) }}">{{ $category->name_cat }} <span class="badge">{{ count($category->objects) }}</span></a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if (!Auth::guest() && Auth::user()->confirmed == 1 && Auth::user()->valid == 1)
                                        <li><a href="{{ url('/objects/create') }}">Добавить объект</a></li>
                                        <li><a href="{{ url('/requests/create') }}">Добавить заявку</a></li>
                                    @endif
                                    <li><a href="{{ url('/userobjects') }}">Мои объекты</a></li>
                                    <li><a href="{{ url('/userrequests') }}">Мои заявки</a></li>

                                    <li><a href="/users/{{Auth::user()->id}}/edit">Редактировать профиль</a></li>
                                    <li><a href="/home">На главную</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Выход
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

</body>
</html>
