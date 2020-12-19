<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="">

    <title>Dashboard - Admin</title>

    <link href="{{ asset ('css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset ('css/jqvmap.css') }}" rel="stylesheet">
    <link href="{{ asset ('css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset ('css/fullcalendar.min.css') }}" rel="stylesheet">
    <link href="{{ asset ('css/admin-materialize.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body id="body" class="has-fixed-sidenav">
    <div id="app">
        <app></app>
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset ('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/jquery.vmap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/jquery.vmap.world.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/jquery.vmap.sampledata.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/Chart.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/Chart.Financial.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/imagesloaded.pkgd.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/masonry.pkgd.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/dashboard.min.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>