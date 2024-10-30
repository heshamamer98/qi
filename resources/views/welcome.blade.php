<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        @vite('resources/js/app.js')

    <script>
        setTimeout(() => {
            window.Echo.channel('commentChannel')
            .listen('commentEvent', (e) => {
                console.log(e);
            })
        }, 200);
    </script>

    </body>
</html>
