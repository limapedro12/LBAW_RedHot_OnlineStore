@section('content')
    <section>
        <div class="profile">
            <div class="profilePicContainer">
                <div class="profilePic">
                    <img src="{{ $admin->getProfileImage() }}" alt="Imagem de Perfil de {{ $admin->nome }}">
                </div>
            </div>
            <div class="profileInfo">
                <div class="profileTitle">
                    <h1>Detalhes</h1>
                </div>
                <div class="profileData">
                    <table class="profileTable">
                        <tr>
                            <th>Nome</th>
                            <td>{{ $admin->nome }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $admin->email }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('layouts.adminHeaderFooter')
