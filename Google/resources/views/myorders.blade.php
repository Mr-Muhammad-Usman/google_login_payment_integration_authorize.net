<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Orders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
<div class="container">

    <h2>My Orders</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Name on Card </th>
            <th>Amount </th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order as $item)
            <tr>
                <td>{{ $item->name_on_card }}</td>
                <td>${{ $item->amount }}</td>
                <td>{{ $item->quantity }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>

</body>
</html>
