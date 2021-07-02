<!--JeCodeLeSoir-->
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/app.css" rel="stylesheet" type="text/css">
    <title>Index</title>

    <script src="{{ asset('js/') }}/app.js" defer></script>
</head>
<body>
    <header class="header">
        <ul>
            <li><a href="{{ url('/')}}">Tchat</a></li>
        </ul>
    </header>

    @yield('content')

    <footer class="footer">
        Tchat by JeCodeLeSoir {{ date('Y')}}
    </footer>
</body>
</html>