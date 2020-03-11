<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Instaprotection Panel') }}</title>

    <!-- Scripts -->
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- <script src="{{asset('js/jquery.min.js')}}"></script> -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css "></link>
    <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css "></link>
    <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css "></link>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->

    <script src=" https://code.jquery.com/jquery-3.3.1.js "></script>

    <script src=" https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js "></script>
    <script src=" https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js "></script>
    <script src=" https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js "></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js "></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js "></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js "></script>
    <script src=" https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js "></script>
    <script src=" https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js "></script>
    <script src=" https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- Styles -->
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i><h4>{{ config('app.name', 'Instaprotection Panel') }}</h4></i>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if(Auth::user())
                            <a class="nav-link" href="{{route('home')}}"><b>Search</b></a>
                            
                            @if(Auth::user()->role == 0)
                            <a class="nav-link" href="{{route('usermanage')}}"><b>User Manage</b></a>
                            <a class="nav-link" href="{{route('imei_data')}}"><b>IMEI Data</b></a>
                            <a class="nav-link" href="{{route('service_center')}}"><b>Service Center</b></a>
                            @endif

                            @if(Auth::user()->role == 1)
                            <a class="nav-link" href="{{route('usermanage')}}"><b>User Manage</b></a>
                            <a class="nav-link" href="{{route('imei_data')}}"><b>IMEI Data</b></a>
                            @endif

                            @if(Auth::user()->role == 3)
                            <a class="nav-link" href="{{route('imei_data')}}"><b>IMEI Data</b></a>
                            @endif

                        @endif
                    </ul>
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
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
