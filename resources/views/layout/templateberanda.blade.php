<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title }}</title>
    
    {{-- Font Awesome Icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- CSS files -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/img/Logo_PLN.png" type="image/x-icon">
    <link href="assets_template/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="assets_template/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link href="assets_template/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="assets_template/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="assets_template/dist/css/demo.min.css?1684106062" rel="stylesheet" />
    {{-- Leaflet JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>
    @include('partials/navbar')
    @yield('content')
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="assets_template/dist/js/tabler.min.js?1684106062" defer></script>
    <script src="assets_template/dist/js/demo.min.js?1684106062" defer></script>
</body>

</html>
