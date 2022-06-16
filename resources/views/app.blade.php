<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Fullstack|Laravel|Vuejs</title>
        <link rel="stylesheet" href="/css/app.css"/>

        <script>
            (function(){
                window.Laravel = {
                    csrfToken: '{{ csrf_token() }}'
                }
            })();
        </script>
    </head>
    <body>
       <div id="app"></div>
       <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>
