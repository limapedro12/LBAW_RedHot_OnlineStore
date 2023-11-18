@if(Auth::check())
    @extends('layouts.userLoggedHeaderFooter')
@else
    @extends('layouts.userNotLoggedHeaderFooter')
@endif

@section('content')
    <div class="container">
        <h1>Politicas de Privacidade</h1>
        
        <!-- Add your HTML code for the admin dashboard here -->
        
    </div>
@endsection
