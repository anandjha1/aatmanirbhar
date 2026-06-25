<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @fonts
</head>

<body>
    <h1>Aatmanirbhar Training Center, Madangir Village</h1>

    <p>{{ $qoute }}</p>

</body>

</html>