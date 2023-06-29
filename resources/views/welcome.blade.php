<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TodoNotes</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html { line-height: 1.15; -webkit-text-size-adjust: 100%; }
        body { margin: 0; }
        /* ... your other styles ... */
    </style>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="antialiased">
<div id="app">
        <login-component v-if="!isLoggedIn" @login-success="loadTodoNotes"></login-component>
        <todo-notes-component v-else></todo-notes-component>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
