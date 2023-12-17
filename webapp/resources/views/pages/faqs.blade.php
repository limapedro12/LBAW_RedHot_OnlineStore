@section('title', "FAQ's |")

@section('content')
    <section>
        <div class="faqs">
            <div class="faqsTitle">
                <h1>Perguntas Frequentes</h1>
            </div>

            <div class="faqsDisplay">
                @foreach ($faqs as $faq)
                    <div class="faq">
                        <div class="faqQuestion">
                            <h2>{{ $faq->pergunta }}</h2>
                            <span class="faqArrow"><i class="fas fa-sort-down"></i></span>
                        </div>
                        <div class="faqAnswer">
                            <p>{{ $faq->resposta }}</p>
                        </div>
                    </div>
                @endforeach
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
