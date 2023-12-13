@section('content')
    <section>
        <div class="ppTous">
            <div class="ppTous-container">
                <h1>Politicas de Privacidade</h1>
                <p>
                    A RedHot respeita a sua privacidade e compromete-se a proteger as suas informações pessoais.
                    Esta Política de Privacidade detalha como recolhemos, utilizamos e divulgamos informações
                    recolhidas através do nosso site, produtos e serviços.
                </p>

                <h2>-- Recolha de Informações --</h2>
                <p>
                    Podemos recolher informações pessoais como o seu nome, endereço de e-mail, número de telefone
                    e localização quando interage com o nosso site, produtos e serviços. Podemos também recolher
                    informações não pessoais, como o seu endereço IP, tipo de navegador e informações do dispositivo.
                </p>

                <h2>-- Utilização de Informações --</h2>
                <p>
                    Utilizamos as informações recolhidas para fornecer e melhorar os nossos produtos e serviços,
                    comunicar consigo, personalizar a sua experiência e cumprir obrigações legais. Podemos também
                    utilizar as suas informações para enviar comunicações de marketing, caso tenha dado o seu
                    consentimento para as receber.
                </p>

                <h2>-- Partilha de Informações --</h2>
                <p>
                    Podemos partilhar as suas informações pessoais com os nossos prestadores de serviços, parceiros
                    e outros terceiros que nos ajudam a fornecer e melhorar os nossos produtos e serviços.
                    Podemos também partilhar as suas informações para cumprir obrigações legais ou para proteger os
                    nossos direitos ou propriedade.
                </p>

                <h2>-- Segurança dos Dados --</h2>
                <p>
                    Tomamos medidas razoáveis para proteger as suas informações pessoais contra acesso não autorizado,
                    divulgação ou uso indevido. No entanto, nenhuma transmissão de dados pela Internet ou sistema de
                    armazenamento pode ser garantida como 100% segura. Portanto, não podemos garantir a segurança das
                    suas informações.
                </p>

                <h2>-- Retenção de Dados --</h2>
                <p>
                    Manteremos as suas informações pessoais pelo tempo necessário para cumprir os fins para os quais
                    foram recolhidas, para cumprir obrigações legais ou para proteger os nossos direitos ou propriedade.
                </p>

                <h2>-- Os Seus Direitos --</h2>
                <p>
                    Tem o direito de aceder, corrigir ou eliminar as suas informações pessoais. Tem também o direito de
                    opor-se ou restringir o processamento das suas informações pessoais. Para exercer estes direitos,
                    entre em contacto connosco através das informações fornecidas abaixo.
                </p>

                <h2>-- Alterações a esta Política de Privacidade --</h2>
                <p>
                    Podemos atualizar esta Política de Privacidade ocasionalmente. Notificaremos quaisquer alterações ao
                    publicar a nova Política de Privacidade no nosso site. Encorajamos a rever esta Política de Privacidade
                    periodicamente para se manter informado sobre como recolhemos, utilizamos e divulgamos as suas
                    informações.
                </p>

                <h2>-- Contacte-nos --</h2>
                <p>Se tiver alguma dúvida ou preocupação sobre esta Política de Privacidade, por favor, contacte-nos através
                    de
                    <b>ajuda@redhot.pt</b>.
                </p>
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
