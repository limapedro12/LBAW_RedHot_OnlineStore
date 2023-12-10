@section('content')
    <section>
        @if (Auth::check() && Auth::user()->id == $user->id)
            <div class="myNotifications">
                @if ($unreadNotifications == 1)
                    <a href="{{ route('notifications', ['user_id' => Auth::id()]) }}">
                        <div class="numberOfNotifications">
                            <p><i class="fas fa-bell"></i> {{ $unreadNotifications }} Notificação não visualizada</p>
                        </div>
                    </a>
                @elseif ($unreadNotifications > 1)
                    <a href="{{ route('notifications', ['user_id' => Auth::id()]) }}">
                        <div class="numberOfNotifications">
                            <p><i class="fas fa-bell"></i> {{ $unreadNotifications }} Notificações não visualizadas</p>
                        </div>
                    </a>
                @endif
            </div>
        @endif
        <div class="profile">
            <div class="profilePicContainer">
                <div class="profilePic">
                    <img src="{{ $user->getProfileImage() }}" alt="Imagem de Perfil de {{ $user->nome }}">
                </div>
            </div>
            <div class="profileInfo">
                <div class="profileTitle">
                    <h1>Detalhes</h1>
                    @if (Auth::check() && Auth::user()->id == $user->id)
                        <div class="profileLinks">
                            <a href="/users/{{ $user->id }}/edit"><i class="fas fa-user-pen"></i></a>
                        </div>
                    @endif
                </div>
                <div class="profileData">
                    <table class="profileTable">
                        <tr>
                            <th>Nome</th>
                            <td>{{ $user->nome }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        @if ((Auth::check() && Auth::user()->id == $user->id) || Auth::guard('admin')->check())
                            <tr>
                                <th>Telefone</th>
                                <td>{{ $user->telefone }}</td>
                            </tr>
                            <tr>
                                <th>Morada</th>
                                <td>{{ $user->morada }}</td>
                            </tr>
                            <tr>
                                <th>Código Postal</th>
                                <td>{{ $user->codigo_postal }}</td>
                            </tr>
                            <tr>
                                <th>Localidade</th>
                                <td>{{ $user->localidade }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Nº de Encomendas</th>
                            <td>{{ $totalOrders }}</td>
                        </tr>
                        <tr>
                            <th>Nº de Reviews</th>
                            <td>{{ $totalReviews }}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
        @if ((Auth::check() && Auth::user()->id == $user->id) || Auth::guard('admin')->check())
            <div class="profileOrders">

                <div class="profileTitle">
                    <h1>Minhas Encomendas</h1>
                </div>

                <div class="topOfTable">
                    <div class="filterTable">
                        <input type="text" id="filterInput" placeholder="Pesquisar..." title="Filtrar Tabela">
                    </div>
                </div>

                <div class="myOrdersTable">
                    <div class="myOrdersTableBody">
                        <table class="tableSortable" id="tableToFilter">
                            <thead>
                                <tr>
                                    <th>Encomenda</th>
                                    <th>Data</th>
                                    <th>Estado</th>
                                    <th>Preço</th>
                                    <th>Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <div class="myOrderID">
                                                <p>
                                                    {{ $order->id }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="myOrderDate">
                                                <p>
                                                    {{ $order->timestamp }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="myOrderStatus">
                                                <p>
                                                    {{ $order->estado }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="myOrderPrice">
                                                <p>
                                                    {{ $order->total }}€
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="myOrderDetails">
                                                <a href="/orders/{{ $order->id }}">+Info</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
