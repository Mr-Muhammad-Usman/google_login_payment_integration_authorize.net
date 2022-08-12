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
            <li><a href="{{ route('ChasePage') }}">Chase</a></li>
        </ul>
    </div>
</nav>
<section class="container-fluid inner-Page" >
    <div class="card-panel">
        <div class="media wow fadeInUp" data-wow-duration="1s">
            <div class="companyIcon">
            </div>
            <div class="media-body">

                <div class="container">

                    <div class="row">
                        <div class="col-md-6">
                            <h1>Pay with Authorize.Net</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6" style="background: lightgreen; border-radius: 5px; padding: 10px;">
                            <div class="panel panel-primary">
                                <div class="creditCardForm">
                                    <div class="payment">
                                        <form id="payment-card-info" method="post" action="{{ route('authorizePayment') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group owner col-md-8">
                                                    <label for="owner">Owner</label>
                                                    <input type="text" class="form-control" id="owner" name="owner" >
                                                    <span style="color: red">@error('owner'){{$message}}@enderror</span>
                                                </div>
                                                <div class="form-group CVV col-md-4">
                                                    <label for="cvv">CVV</label>
                                                    <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" >
                                                    <span style="color: red">@error('cvv'){{$message}}@enderror</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-8" id="card-number-field">
                                                    <label for="cardNumber">Card Number</label>
                                                    <input type="text" maxlength="16" class="form-control" id="cardNumber" name="cardNumber" >
                                                    <span style="color: red">@error('cardNumber'){{$message}}@enderror</span>
                                                </div>
{{--                                                <div class="form-group col-md-4" >--}}
{{--                                                    <label for="amount">Amount</label>--}}
{{--                                                    <input type="number" class="form-control" id="amount" name="amount" required>--}}
{{--                                                </div>--}}
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6" id="expiration-date">
                                                    <label>Expiration Date</label><br/>
                                                    <select class="form-control" id="expiration-month" name="expiration_month" style="float: left; width: 100px; margin-right: 10px;">

                                                        <option value="" >select</option>
                                                        <option value="01" >Jan</option>
                                                        <option value="02" >Feb</option>
                                                        <option value="03" >March</option>
                                                        <option value="04" >April</option>
                                                        <option value="05" >May</option>
                                                        <option value="06" >Jun</option>
                                                        <option value="07" >Jul</option>
                                                        <option value="08" >Aug</option>
                                                        <option value="09" >Sep</option>
                                                        <option value="10" >Oct</option>
                                                        <option value="11" >Nov</option>
                                                        <option value="12" >Dec</option>

                                                    </select>
                                                    <span style="color: red">@error('expiration_month'){{$message}}@enderror</span>
                                                    {{--                                                    <input type="month" class="form-control" id="expiration-year" name="expiration-year">--}}
                                                    <select class="form-control" id="expiration-year" name="expiration_year"  style="float: left; width: 100px;">


                                                        <option value="">select</option>
                                                        <option value="2023">2023</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                        <option value="2026">2026</option>
                                                        <option value="2027">2027</option>
                                                        <option value="2028">2028</option>
                                                        <option value="2029">2029</option>
                                                        <option value="2030">2030</option>

                                                    </select>
                                                    <span style="color: red">@error('expiration_year'){{$message}}@enderror</span>
                                                </div>
                                                <div class="form-group col-md-6" id="credit_cards" style="margin-top: 22px;">
                                                    <img src="{{ asset('images/visa.jpg') }}" id="visa">
                                                    <img src="{{ asset('images/mastercard.jpg') }}" id="mastercard">
                                                    <img src="{{ asset('images/amex.jpg') }}" id="amex">
                                                </div>
                                            </div>

                                            <br/>
                                            <div class="form-group" id="pay-now">

                                                @if(session()->has('message_text'))
                                                    <p>{{ session()->get('message_text') }}</p>
                                                @endif
                                                <button type="submit" class="btn btn-success themeButton" id="confirm-purchase">Confirm Payment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-5" style="background: lightblue; border-radius: 5px; padding: 10px;">
                            <h3>Sample Data</h3>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>
                                        Owner
                                    </th>
                                    <td>
                                        Simon
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        CVV
                                    </th>
                                    <td>
                                        123
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Card Number
                                    </th>
                                    <td>
                                        4111 1111 1111 1111
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Amount
                                    </th>
                                    <td>
                                        $99
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Expiration Date
                                    </th>
                                    <td>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="clearfix"></div>
</section>

</body>
</html>
