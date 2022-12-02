<!DOCTYPE html>
<html class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <title></title>
    @vite('resources/js/app.js')
</head>
<body class="font-sans antialiased h-full">

<div class="py-12 flex flex-col items-center space-y-6">

    <div class="bg-white mx-4 sm:w-2/3 rounded-md py-10 py-4 flex flex-col items-center space-y-4">

        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="20" cy="20" r="20" fill="#BFDBFE" />
            <path d="M11.75 21.5L22.25 10.25L20 18.5H28.25L17.75 29.75L20 21.5H11.75Z" stroke="#2563EB" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        <div class="flex flex-col items-center">
            <span class="text-xl font-semibold text-gray-600">Energieausweis Express</span>
            <span class="text-xs text-gray-400">Eine Marke von bauzertifikate.de</span>
        </div>

    </div>

    <div class="bg-white flex flex-col items-center mx-4 sm:w-2/3 rounded-md py-10 py-4 px-4 space-y-6">
        {{ $slot }}
    </div>

    <div class="bg-white flex flex-col items-center mx-4 sm:w-2/3 rounded-md py-10 py-4 px-4 space-y-6">
        <div class="flex justify-between space-x-4 text-xs text-gray-400">
            <a href="mailto:david@bauzertifikate.de">david@bauzertifikate.de</a>
            <a href="https://www.energieausweis-express.de">www.energieausweis-express.de</a>
            <span>+49 172 2541810</span>
        </div>
    </div>

    <span class="text-xs text-gray-400">&copy; 2021 bauzertifikate.de. All rights reserved.</span>

</div>


</body>
</html>
