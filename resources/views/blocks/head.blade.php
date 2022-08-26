<head>
    {!! SEOMeta::generate() !!}
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#6164bd">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico">
    <link rel="icon" type="image/svg+xml" href="/images/favicon/favicon.svg">
    <link rel="icon" type="image/png" href="/images/favicon/favicon.png">
    <meta name="apple-mobile-web-app-title" content="name">
    <meta name="application-name" content="name">
    <meta name="cmsmagazine" content="18db2cabdd3bf9ea4cbca88401295164">
    <meta name="author" content="Fanky.ru">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="msapplication-config" content="/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    {!! OpenGraph::generate() !!}
    <link href="/fonts/RussoOneRegular.woff2" rel="preload" as="font" type="font/woff2" crossorigin="anonymous">
    <link href="/fonts/InterRegular.woff2" rel="preload" as="font" type="font/woff2" crossorigin="anonymous">
    <link href="/fonts/InterMedium.woff2" rel="preload" as="font" type="font/woff2" crossorigin="anonymous">
    <link href="/fonts/InterBold.woff2" rel="preload" as="font" type="font/woff2" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/all.css') }}" media="all">
    <script src="{{ mix('/js/all.js') }}" defer=""></script>
</head>
