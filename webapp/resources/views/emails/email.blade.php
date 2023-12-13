<h1>Olá, {{ $mailData['name'] }}!</h1>
<h2>Este email serve para recuperação de password.</h2>
<h5><a href="http://lbaw2352.lbaw.fe.up.pt/users/{{$mailData['id']}}/change_password/{{$mailData['token']}}">Link</a></h5>
<h5>RedHot Team</h5>

<h5><a href="http://localhost:8000/users/{{$mailData['id']}}/change_password/{{$mailData['token']}}">(Link localhost)</a></h5>