<!DOCTYPE html>
<html>
    <head>
        <title>Editar Perfil | {{$user->nome}} | RedHot</title>
    </head>
    <body>
        <h1>A editar perfil de {{$user->nome}}</h1>
        <form method="post" action="/users/{{$user->id}}/edit">
            @csrf
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="{{$user->nome}}"><br><br>
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" value="{{$user->email}}"><br><br>
            <label for="email">Password</label>
            <input type="password" id="password" name="password" required><br><br> 
            <input type="submit" value="Submeter">
        </form>
    </body>
</html>
