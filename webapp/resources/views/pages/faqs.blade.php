@section('content')
    <div class="ppTous">
        <div class="ppTous-container">
            <h1>FAQ's</h1>
            <p> A ser implementado... </p>
        </div>
    </div>
@endsection

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif