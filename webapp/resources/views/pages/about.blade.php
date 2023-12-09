@section('content')
    <div class="aboutContent">
        <div class="aboutRowOne">
            <div class="aboutRowOneContentLeft">
                <div class="aboutTitle">
                    <h1 class="one">A NOSSA HISTÓRIA</h1>
                </div>
                <div class="aboutTextSeparator"></div>

                <div class="aboutText">
                    <p class="one">
                        A RedHot nasceu da paixão de um grupo de estudantes da Licenciatura em Engenharia Informática e
                        Computação na FEUP, como projeto da UC LBAW. Movidos pelo crescente interesse pela cultura dos
                        picantes, decidimos criar uma loja online dedicada à venda de produtos relacionados, oferecendo
                        uma experiência única aos entusiastas destes sabores únicos.
                    </p>
                </div>
            </div>
            <div class="aboutRowOneContentRight">
                <div class="aboutImage">
                    <img src="{{ asset('sources/about/aboutImageOne.png') }}" alt="About Image One">
                </div>
            </div>
        </div>
        <div class="aboutRowTwo">
            <div class="aboutRowTwoContentLeft">
                <div class="aboutImage">
                    <img src="{{ asset('sources/about/aboutImageTwo.jpg') }}" alt="About Image Two">
                </div>
            </div>
            <div class="aboutRowTwoContentRight">
                <div class="aboutTitle">
                    <h1 class="two">OS NOSSOS PRODUTOS</h1>
                </div>
                <div class="aboutTextSeparatorTwo"></div>
                <div class="aboutText">
                    <p class="two">
                        Na RedHot, proporcionamos uma ampla variedade de produtos relacionados com malaguetas e
                        picantes. Desde utensílios e sementes para cultivo próprio até uma vasta gama de produtos
                        picantes de diversas marcas, incluindo a nossa fictícia marca própria. Queremos ser a referência
                        na venda destes produtos, contribuindo para a disseminação do conhecimento sobre este universo
                        fascinante.
                    </p>
                </div>
                <a href="{{ url('/products') }}">
                    <div class="aboutButtonToProducts">
                        Ver Produtos
                    </div>
                </a>
            </div>
        </div>
        <div class="aboutRowThree">
            <div class="aboutRowThreeContent">
                <div class="aboutTitle">
                    <h1 class="three">A NOSSA EQUIPA</h1>
                </div>
                <div class="aboutTextSeparatorThree"></div>
                <div class="aboutText">
                    <p class="three">
                        A RedHot é composta por uma equipa de 4 elementos, todos eles estudantes da Licenciatura em
                        Engenharia Informática e Computação na FEUP. A nossa equipa é composta por João Mota, Pedro
                        Januário, Pedro Lima e Pedro Landolt, todos eles com o objetivo de criar uma loja online dedicada
                        à venda de produtos relacionados com malaguetas e picantes.
                    </p>
                </div>
                <div class="aboutTeam">
                    <div class="aboutTeamMember">
                        <div class="aboutTeamMemberImage">
                            <img src="{{ asset('sources/about/Mota.jpg') }}" alt="About Team Member One">
                        </div>
                        <div class="aboutTeamMemberName">
                            <h2 class="three">João Mota</h2>
                        </div>
                        <div class="aboutTeamMemberNickname">
                            <h4 class="three">Jonathan Motorbikes (Sardinhas)</h4>
                        </div>
                        <div class="aboutTeamMemberRole">
                            <h3 class="three">CO-FOUNDER</h3>
                        </div>
                        <div class="aboutTeamMemberDescription">
                            <p class="three">
                                CO-FOUNDER da empresa, responsável pela gestão da empresa e pela gestão de recursos
                                humanos.
                            </p>
                        </div>
                        <div class="aboutTeamMemberSocialMedia">
                            <a href="https://www.instagram.com/joao_mota_22/"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://www.linkedin.com/in/joãomota/"><i class="fa-brands fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="aboutTeamMember">
                        <div class="aboutTeamMemberImage">
                            <img src="{{ asset('sources/about/Janu.jpg') }}" alt="About Team Member Two">
                        </div>
                        <div class="aboutTeamMemberName">
                            <h2 class="three">Pedro Januário</h2>
                        </div>
                        <div class="aboutTeamMemberNickname">
                            <h4 class="three">Janeiras</h4>
                        </div>
                        <div class="aboutTeamMemberRole">
                            <h3 class="three">CO-FOUNDER</h3>
                        </div>
                        <div class="aboutTeamMemberDescription">
                            <p class="three">
                                CO-FOUNDER da empresa, responsável pela gestão da empresa e pela gestão de recursos
                                humanos.
                            </p>
                        </div>
                        <div class="aboutTeamMemberSocialMedia">
                            <a href="https://www.instagram.com/pedro_januario03/"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://www.linkedin.com/in/pedro-januario-352421266/"><i
                                    class="fa-brands fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="aboutTeamMember">
                        <div class="aboutTeamMemberImage">
                            <img src="{{ asset('sources/about/Lima.jpg') }}" alt="About Team Member Three">
                        </div>
                        <div class="aboutTeamMemberName">
                            <h2 class="three">Pedro Lima</h2>
                        </div>
                        <div class="aboutTeamMemberNickname">
                            <h4 class="three">Peter Limes</h4>
                        </div>
                        <div class="aboutTeamMemberRole">
                            <h3 class="three">CO-FOUNDER</h3>
                        </div>
                        <div class="aboutTeamMemberDescription">
                            <p class="three">
                                CO-FOUNDER da empresa, responsável pela gestão da empresa e pela gestão de recursos
                                humanos.
                            </p>
                        </div>
                        <div class="aboutTeamMemberSocialMedia">
                            <a href="https://www.instagram.com/pedro.lima.12/"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://www.linkedin.com/in/pedro-lima-b55558295/"><i
                                    class="fa-brands fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="aboutTeamMember">
                        <div class="aboutTeamMemberImage">
                            <img src="{{ asset('sources/about/Landolt.jpg') }}" alt="About Team Member Four">
                        </div>
                        <div class="aboutTeamMemberName">
                            <h2 class="three">Pedro Landolt</h2>
                        </div>
                        <div class="aboutTeamMemberNickname">
                            <h4 class="three">Peter Landolts 🍞</h4>
                        </div>
                        <div class="aboutTeamMemberRole">
                            <h3 class="three">CO-FOUNDER</h3>
                        </div>
                        <div class="aboutTeamMemberDescription">
                            <p class="three">
                                CO-FOUNDER da empresa, responsável pela gestão da empresa e pela gestão de recursos
                                humanos.
                            </p>
                        </div>
                        <div class="aboutTeamMemberSocialMedia">
                            <a href="https://www.instagram.com/l0ok_48/"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://www.linkedin.com/in/pedrolandolt/"><i class="fa-brands fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
