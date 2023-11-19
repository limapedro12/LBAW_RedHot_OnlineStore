@section('content')
    <div class="container">
        <h1>Termos de Uso</h1>
        
        <!-- Add your HTML code for the admin dashboard here -->
        
    </div>
@endsection

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif

