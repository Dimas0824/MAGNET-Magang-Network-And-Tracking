<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="bg-magnet-frost-mist text-black">
    {{ $slot }}

    @fluxScripts
</body>

</html>