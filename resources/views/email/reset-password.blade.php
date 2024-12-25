<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CIS | Reestablecer contraseña</title>
</head>

<body>
    <div>
        <img src="{{ asset('images/cis-logo.webp') }}" alt="Logo CIS"
            style="width:80px; height:80px; object-fit:cover; margin-inline:auto;">
    </div>
    <h1 style="text-align:center; font-size:1.5rem; font-weight:bold; color:#333; margin-top:10px;">
        Reestablecer contraseña
    </h1>
    <p style="text-align:center; font-size:1rem; color:#666; margin-top:5px;">
        Hola {{ $name }}, ingresa al siguiente enlace para reestablecer tu contraseña, este enlace expirará en
        60 minutos.
    </p>
    <div style="text-align:center;">
        <a href="{{ $url }}"
            style="display:block; text-align:center; font-size:1rem; text-decoration:none; margin-top:10px; padding:10px; border-radius:5px; background-color:#007bff; color:#fff; width:max-content; margin-inline:auto;">
            Reestablecer contraseña
        </a>
    </div>
</body>

</html>
