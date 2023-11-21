@section('content')
<section>
    <div class="ppTous">
        <div class="ppTous-container">
            <h1>Sobre nós</h1>
            <p> A ser implementado... </p>
        </div>
    </div>
</section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
