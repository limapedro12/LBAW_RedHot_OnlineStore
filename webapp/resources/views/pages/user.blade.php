<!DOCTYPE html>
<html>
    <head>
        <title>{{$user->nome}} | RedHot</title>
    </head>
    <body>
        <h1>{{$user->nome}}</h1>
        <p>{{$user->email}}</p>
        <a href="/users/{{$user->id}}/edit">Editar Perfil...</a>
        <a href="/users/{{$user->id}}/delete_account">Apagar Conta...</a>
    </body>
</html>
