<h1>Olá, {{ $mailData['name'] }}!</h1>
<h2>Recebeu uma notificação na sua conta RedHot.</h2>
<h3>Notificação:</h3>
<h4>{{$mailData['emailMessage']}}</h4>
<h5><a href="http://lbaw2352.lbaw.fe.up.pt{{$mailData['url']}}">Link para a sua página de Notificações</a></h5>
<h5>RedHot Team</h5>