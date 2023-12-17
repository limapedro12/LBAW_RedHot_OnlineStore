@section('title', 'Termos de Uso |')
@section('content')
    <section>
        <div class="ppTous">
            <div class="ppTous-container">
                <h1>Termos de Uso</h1>
                <p>
                    Bem-vindo à RedHot, a sua loja online dedicada aos apaixonados por picantes.
                    Ao utilizar o nosso site, produtos e serviços, concorda em ficar vinculado
                    pelos seguintes Termos de Uso, que regem a sua experiência de compra connosco.
                </p>

                <h2>-- Propriedade Intelectual --</h2>
                <p>
                    Todo o conteúdo no site da RedHot, incluindo textos, gráficos, logótipos,
                    imagens e software, é propriedade exclusiva da RedHot e está protegido por leis
                    de propriedade intelectual. A reprodução, distribuição ou modificação do conteúdo
                    sem o nosso consentimento prévio por escrito é estritamente proibida.
                </p>

                <h2>-- Condições de Utilização --</h2>
                <p>
                    Ao utilizar o nosso site, compromete-se a não utilizar os nossos produtos e serviços
                    para fins ilícitos ou que possam prejudicar a integridade do site. Não pode utilizar
                    o nosso site para assediar, ameaçar ou obter informações pessoais de outros utilizadores.
                </p>

                <h2>-- Conteúdo do Utilizador --</h2>
                <p>
                    Qualquer conteúdo que submeta para o nosso site, como comentários, avaliações e feedback,
                    é considerado conteúdo do utilizador. Mantém a propriedade do seu conteúdo, mas ao
                    submetê-lo, concede-nos o direito de utilizá-lo para melhorar a experiência global da
                    RedHot.
                </p>

                <h2>-- Devoluções e Reembolsos --</h2>
                <p>
                    A RedHot permite devoluções dentro de um prazo máximo de 30 dias após a compra. Para
                    solicitar uma devolução, entre em contacto connosco através do nosso serviço de apoio ao
                    cliente. O produto devolvido deve estar em condições originais, sem sinais de uso indevido.
                    Após a verificação, processaremos o reembolso ou forneceremos uma alternativa adequada.
                </p>

                <h2>-- Limitação de Responsabilidade --</h2>
                <p>
                    A RedHot não será responsável por danos diretos, indiretos, incidentais ou consequenciais
                    decorrentes do uso dos nossos produtos ou serviços. Apesar de tomarmos medidas para garantir
                    a qualidade dos nossos produtos, a sua utilização está sujeita à sua responsabilidade.
                </p>

                <h2>-- Indemnização --</h2>
                <p>
                    Compromete-se a indemnizar e isentar de responsabilidade a RedHot, suas afiliadas e
                    colaboradores de qualquer reclamação decorrente do seu uso indevido dos produtos ou violação
                    destes Termos de Uso.
                </p>

                <h2>-- Rescisão --</h2>
                <p>
                    A RedHot reserva-se o direito de rescindir o acesso ao site, produtos ou serviços a qualquer
                    momento e por qualquer motivo, sem aviso prévio.
                </p>

                <h2>-- Lei Aplicável --</h2>
                <p>
                    Estes Termos de Uso serão regidos e interpretados de acordo com as leis de Portugal, sem
                    considerar os princípios de conflitos de leis.
                </p>

                <h2>-- Alterações aos Termos de Uso --</h2>
                <p>
                    Podemos atualizar estes Termos de Uso ocasionalmente. Notificaremos quaisquer alterações ao
                    publicar os novos Termos de Uso no nosso site. Encorajamos a rever estes Termos de Uso
                    periodicamente para se manter informado sobre quaisquer alterações.
                </p>

                <h2>-- Contacte-nos --</h2>
                <p>
                    Se tiver alguma dúvida ou preocupação sobre estes Termos de Uso, entre em contacto connosco
                    através de <b>ajuda@redhot.pt</b>.
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
