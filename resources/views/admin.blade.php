<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('/css/admin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
</head>
<body>
<noscript>
    <strong>We're sorry but this app doesn't work properly without
        JavaScript enabled. Please enable it to continue.</strong>
</noscript>
<div id="app">
</div>

<!-- <script src="js/app.js"></script> -->
<script src="{{ mix('js/admin/index.js') }}"></script>

</body>
</html>
