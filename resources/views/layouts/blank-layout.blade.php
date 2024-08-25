<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Dinasty Group</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('landing/vendor-dashboard/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('landing/assets-dashboard/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets-dashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets-dashboard/css/animated.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets-dashboard/css/owl.css') }}">
    @livewireStyles
</head>

<body>

    {{ $slot }}

</body>

</html>