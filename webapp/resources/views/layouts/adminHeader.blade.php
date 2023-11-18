<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
    </head>
    <body>
        <main>
            <header>
                <section class="headerBar">
                    <!-- Ao clicar no logo somos rederecionados para a main page -->
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ url('../sources/logo/logo_lbaw.png') }}" alt="RedHot" width="140">
                    </a>

                    <!-- Acessos rapidos -->
                    <nav class="navBar">
                        <a href="{{ url('/admin') }}">Dashboard</a>
                        <a href="{{ url('/admin/users') }}">Notificações</a>
                        <a href="{{ url('/admin/categories') }}">Admin</a>
                        <a class="button" href="{{ url('/logout') }}">Logout</a> <span>{{ Auth::user()->name }}</span>
                    </nav>
                </section>
            </header>
            <section id="content">
                @yield('content')
            </section>
            <footer>
                <p>Footer</p>
            </footer>
        </main>
    </body>
</html>