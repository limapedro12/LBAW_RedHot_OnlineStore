@section('content')
    <div class="container">
        <h1>Politicas de Privacidade</h1>
        
        <!-- Add your HTML code for the admin dashboard here -->
        
    </div>
@endsection

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
    
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif
