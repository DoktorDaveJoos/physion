<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Bauzertifikate') }}</title>

        <!-- Fathom - beautiful, simple website analytics -->
        <script src="https://cdn.usefathom.com/script.js" data-spa="auto" data-site="{{ config('tracking.fathom')  }}" defer></script>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('tracking.ads') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', {{ config('tracking.ads') }});
        </script>

        <script>
            var blackChatScript = document.createElement("script");
            blackChatScript.type = "text/javascript";
            blackChatScript.async = true;
            blackChatScript.src = "https://cdn.getblackchat.com/chat.js";
            blackChatScript.onload = function () {
                window.BlackChat({"team-token":"dc1310e8-1389-41e0-ade5-c15f10176ae3"});
            };
            var scriptElement = document.getElementsByTagName("script")[0];
            scriptElement.parentNode.insertBefore(blackChatScript, scriptElement);
        </script>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend:wght@400;500&display=swap">
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700;900&family=Roboto+Mono:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
    @include('cookie-consent::index')
</html>
