<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    @vite('resources/css/app.css')
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <style>
      body {
        background-color: lightgray
      }
    </style>
  </head>
  <body>
    @inertia
    {{-- <h1 class="text-3xl font-bold underline">
        Hello world!
    </h1> --}}
  </body>
</html>
