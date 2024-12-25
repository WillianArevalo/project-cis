<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        (function() {
            let theme = localStorage.getItem('theme') || "light"
            if (theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                        '(prefers-color-scheme: dark)')
                    .matches)) {
                document.documentElement.classList.add('dark');

            } else {
                document.documentElement.classList.add('light');
            }
        })();
    </script>
</head>

<body>
    <div
        class="fixed inset-0 -z-10 h-full w-full bg-white bg-[linear-gradient(to_right,#f0f0f0_1px,transparent_1px),linear-gradient(to_bottom,#f0f0f0_1px,transparent_1px)] bg-[size:6rem_4rem] dark:hidden">
        <div
            class="absolute bottom-0 left-0 right-0 top-0 bg-[radial-gradient(circle_200px_at_50%_300px,#C9EBFF,transparent)]">
        </div>
    </div>

    <div
        class="fixed top-0 z-[-2] hidden h-screen w-screen bg-neutral-950 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(120,119,198,0.15),rgba(255,255,255,0))] dark:block">
    </div>
    <div class="mx-auto flex min-h-screen flex-col px-4 md:w-[90%] lg:w-[75%] xl:w-[60%]">
        @include('layouts.__partials.usuario.navbar')
        @include('layouts.__partials.loader')
        <main class="flex-1">
            @include('layouts.__partials.toast-container', ['class' => 'top-4 right-4'])
            @include('layouts.__partials.alert')
            @yield('content')
        </main>
        @include('layouts.__partials.usuario.footer')
    </div>
</body>
@vite('resources/js/app.js')


</html>
