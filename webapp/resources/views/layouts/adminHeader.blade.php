<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        

        <!-- Font Awesome cdnjs link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
            integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Styles -->
        <link href="{{ url('css/header.css') }}" rel="stylesheet">
        <link href="{{ url('css/footer.css') }}" rel="stylesheet">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/header.js') }} defer>
        </script>
    </head>
    <body>
        <main>
            
                <section class="headerBar">

                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('sources/logo/logo_lbaw_side.png') }}" alt="RedHot" width="140">
                    </a>
                
                    <nav class="navbar">
                        <form action="../actions/action_logout.php" method="post" class="logout">
                            <a href="{{ url('/admin') }}">Dashboard</a>
                            <a href="{{ url('/admin/users') }}">Notificações</a>
                            <a href="{{ url('/admin/categories') }}">Admin</a>
                        <input type="submit" value="Logout">
                        </form>
                    </nav>
                
                    <div id="menu-bars" class="fas fa-bars"></div>
                
                    </section>
            
            <section id="content">
                @yield('content')
            </section>
            <footer>
                <p>Footer</p>
            </footer>
        </main>
    </body>
</html>