<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Storyteller</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::asset('bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('bootstrap/dist/css/bootstrap-theme.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/storyteller.css') }}">

    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
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
                <a class="navbar-brand logo" href="{{ url('/') }}">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/quest') }}">Public Quests</a></li>
                    @if (Auth::check())
                        <li><a href="{{ url('/quest/own') }}">Your Quests</a></li>
                        <li><a href="{{ url('/quest/create') }}">Create Quest</a></li>
                        @if (Auth::user()->isAdmin())
                            <li>
                                <a href="{{ url('/quest_approving') }}">Quest Approving
                                    @if (\App\Core\Service\QuestApproveService::getNotApprovedCount() > 0)
                                        <span class="badge">{{ \App\Core\Service\QuestApproveService::getNotApprovedCount() }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if (session()->has('flash_notification.message'))
            <div class="alert alert-{{ session('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! session('flash_notification.message') !!}
            </div>
        @endif
    </div>

    @yield('content')

    <!-- JavaScripts -->
    <script src="{{ URL::asset('js/jquery-3.1.0.min.js') }}"></script>
    <script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('js/dataTables.bootstrap.min.js') }}"></script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script type="text/javascript">
        host = 'ws://' + '{{ config('websocket.server_ip') }}' + ':' + '{{ config('websocket.server_port') }}';
    </script>
    <script type="text/javascript" src="{{ URL::asset('js/quest.js') }}"></script>
</body>
</html>
