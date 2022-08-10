<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">{{ Auth::user()->name }}</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ route('orderPage') }}">My Orders</a></li>
            <li><a href="{{ route('authorizePage') }}">Add New Order</a></li>
            <li><a href="{{ route('user_logout') }}">Logout</a></li>
        </ul>
    </div>
</nav>
<div>
    <h1>Thank you For Order</h1>
    <h3>{{Auth::user()->name}}</h3>

</div>

</body>
</html>
