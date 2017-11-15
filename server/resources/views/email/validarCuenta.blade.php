
<p>Estimado, este correo electronico es automatico, y no requiere de respuesta alguna.</p>
<p>En el presente, se encuentra un link de confirmacion para su cuenta de acceso a la plataforma Web</p>
<p>Su contraseña es: {{ $password }}</p>
<p>Su email es: {{ $email }} </p>

<a href="https://fourlayeredapi.herokuapp.com/api/register/verify/{{ $confirmation_code }}">Validar mi cuenta</a>


