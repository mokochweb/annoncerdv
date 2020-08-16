<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{--<script src="{{ asset('js/jquery.js') }}" defer></script>--}}
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--Ad dynamically css and js from controller -->
    <?php if (isset($css_includes)): if (is_array($css_includes)): foreach ($css_includes as $css_include): ?>
    <link href="<?php echo $css_include; ?>" type="text/css" rel="stylesheet"/>
    <?php
    endforeach;
    else:
    ?>
    <link href="<?php echo $css_includes; ?>" rel="stylesheet" media="wait" onload="if(media!='all')media='all'"/>
    <noscript>
        <link rel="stylesheet" href="<?php echo $css_includes; ?>">
    </noscript>
    <?php
    endif;
    endif;

    if (isset($js_includes)): if (is_array($js_includes)): foreach ($js_includes as $js_include):
    ?>
    <script src="<?php echo $js_include; ?>" async defer></script>
    <?php
    endforeach;
    else:
    ?>
    <script src="<?php echo $js_includes; ?>" async defer></script>
    <?php
    endif;
    endif;
    ?>

    <style>
        .tooltip1 {
            position: relative;
            display: inline-block;
            border-bottom: unset;
        }

        .tooltip1 .tooltiptext1 {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip1 .tooltiptext1::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .tooltip1:hover .tooltiptext1 {
            visibility: visible;
            opacity: 1;
        }

        @media only screen and (min-width: 768px) {
            ul.xs-only {
                display: none;
            !important;
            }
        }

    </style>
    <script !src="">
        window.Laravel = {!! json_encode([
    'csrfToken' => csrf_token(),
    'url' => url('/')
]) !!};
    </script>

    <!-- Styles -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    {{-- Toastr CSS --}}
    @toastr_css

    @yield('styles')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            @guest

            @else
                <a class="navbar-brand" href="{{ route('welcome') }}">
                    Accueil
                </a>
                <a class="navbar-brand" href="{{ url('about_us') }}">
                    À propos
                </a>
                <a class="navbar-brand" href="{{ url('contact_us') }}">
                    Contact
                </a>
            @endguest
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse py-3 py-md-0 py-sm-0 py-lg-0" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto ">
                    @guest
                        <ul class="navbar-nav mr-auto xs-only">
                            <li class="nav-item px-4">
                                <a class="nav-link nav-link-font" href="#">Accueil</a>
                            </li>
                            <li class="nav-item px-4">
                                <a class="nav-link nav-link-font" href="#">À propos</a>
                            </li>
                            <li class="nav-item px-4">
                                <a class="nav-link nav-link-font" href="#">Services</a>
                            </li>
                            <li class="nav-item px-4">
                                <a class="nav-link nav-link-font" href="#">Contact</a>
                            </li>
                            <li class="nav-item px-4">
                                <a class="nav-link nav-link-font" href="#">Informations légales</a>
                            </li>
                            <li class="nav-item px-4">
                                <a class="nav-link nav-link-font" href="#">Langues</a>
                            </li>
                        </ul>


                        <form class="d-flex" id="post-login" method="POST" action="{{ route('login') }}">
                            @csrf
                            <li class="nav-item px-1">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <a href="{{ route('password.request') }}">
                                    Identifiant oublié?
                                </a>

                            </li>
                        <li class="nav-item px-1">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password"
                                   required
                                   autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    Mot de passe oublié
                                </a>
                            @endif
                        </li>


                        </form>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <button type="submit" class="btn btn-gold" onclick="event.preventDefault();
                                                     document.getElementById('post-login').submit();">Se connecter</button>
                                <a class="d-block" href="{{ route('register') }}">Crée un compte </a>
                            </li>
                        @endif


                    @else
                        <li class="nav-item dropdown">
                            <button role="button" class="btn btn-gold" id="navbarDropdown" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre> Mon compte
                            </button>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('settings.index') }}">
                                    {{ __('Paramètres') }}
                                </a>
                                <a class="dropdown-item" href="{{ url('posts/my_ads') }}">
                                    {{ __('Mes annonces') }}
                                </a>
                                <a class="dropdown-item notify_dropdown" href="{{ route('messages.index') }}">
                                    {{ __('Ma messagerie') }}
                                    @if(\Helper::get_unread_message_count() > 0)
                                        <span class="badge badge-pill badge-warning unread_noti">
                                          {{ \Helper::get_unread_message_count() }}
                                      </span>
                                    @endif
                                </a>
                                <a class="dropdown-item" href="#">
                                    {{ __("S'abonner") }}
                                </a>
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    {{ __('Les annnonces') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    {{ __('Mon profile') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
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
{{-- Toastr JS --}}
@toastr_js
@toastr_render

@yield('scripts')
</body>
</html>
