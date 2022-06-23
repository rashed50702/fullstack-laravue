<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- @if (Auth::check())
    <meta name="user" content="{{ Auth::user() }}">
    @endif -->
    <title>Fullstack|Laravel|Vuejs</title>
    <link rel="stylesheet" href="/css/app.css" />
    <script>
        (function() {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            }
        })();
    </script>
</head>

<body>
    <div id="app">
        @if(Auth::check())
        <main-component :user="{{Auth::user()}}" :permissions="{{Auth::user()->role->permission}}" />
        @else
        <main-component :user="false" />
        @endif
    </div>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>

</html>