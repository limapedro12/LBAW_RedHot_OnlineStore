<head>
    <title>Gestão de Utilizadores | RedHot</title>
</head>

@extends('layouts.adminHeaderFooter')

@section('content')
    <div class="adminContent">
        <div class="adminPage">
            <div class="adminSideBar">
                <div class="adminSearchBarOnSideBar">
                    <form action="#" method="post">
                        <input type="text" placeholder="Produto..">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="adminSideBarOptions">
                    <a href="{{ url('/admin') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Estatísticas</p>
                        </div>
                    </a>

                    <a href="{{ url('/adminOrders') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Encomendas</p>
                        </div>
                    </a>

                    <a href="{{ url('/adminProductsManage') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Produtos</p>
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </a>

                    <a href="{{ url('/adminUsers') }}">
                        <div class="adminSideBarOption" id="optionSelected">
                            <div id="rectangle"></div>
                            <p>Utilizadores</p>
                        </div>
                    </a>

                    <a href="{{ url('/adminFAQ') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>FAQ's</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="adminOptionContent">
                <div class="adminOptionContentTitle">
                    <h1>Gestão de Utilizadores</h1>
                </div>

                <div class="adminOrderContent">
                    <div class="tableOrders">
                        <div class="profileOrders">

                            <div class="topOfTable">
                                <div class="filterTable">
                                    <input type="text" id="filterInput" placeholder="Pesquisar..."
                                        title="Filtrar Tabela">
                                </div>
                            </div>

                            <div class="myOrdersTable">
                                <div class="myOrdersTableBody">
                                    <table class="tableSortable" id="tableToFilter">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Utilizador</th>
                                                <th>Email</th>
                                                <th>Contacto</th>
                                                <th>Promover / Despromover</th>
                                                <th>Banir / Perdoar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>
                                                        <div class="myOrderID">
                                                            <p>
                                                                {{ $user->getNormalizeUserId($user->id) }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="userFotoName">
                                                            <a href="/users/{{ $user->id }}">
                                                                <img src="{{ $user->getProfileImage() }}"
                                                                    alt="Imagem de Perfil de {{ $user->nome }}"
                                                                    width="50px" height="50px">
                                                            </a>
                                                            <a href="/users/{{ $user->id }}" class="userNameInAdminTable">
                                                                <p>{{ $user->nome }}</p>
                                                                @if ($user->banned)
                                                                    <p> (BANIDO)</p>
                                                                @elseif ($user->became_admin)
                                                                    <p> (PROMOVIDO)</p>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="myOrderDate">
                                                            <p>
                                                                {{ $user->email }}
                                                            </p>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="myOrderStatus">
                                                            <p>
                                                                {{ $user->contacto }}
                                                            </p>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        @if ($user->became_admin)
                                                            <div class="userAdminButtons">
                                                                <form action="/users/{{ $user->id }}/demote"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit" id="demoteUser"
                                                                        value="Despromover a Utilizador">Despromover
                                                                        Utilizador</button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div class="userAdminButtons">
                                                                <form action="/users/{{ $user->id }}/promote"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit" id="promoteUser"
                                                                        value="Promover a Administrador">Promover
                                                                        Utilizador</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($user->banned)
                                                            <div class="userAdminButtons">
                                                                <form action="/users/{{ $user->id }}/forgive"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit" id="forgiveUser"
                                                                        value="Perdoar Utilizador">Perdoar
                                                                        Utilizador</button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div class="userAdminButtons">
                                                                <form action="/users/{{ $user->id }}/ban"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit" id="banUser"
                                                                        value="Banir Utilizador">Banir Utilizador</button>
                                                                </form>
                                                            </div>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
