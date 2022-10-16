<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Order - Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
<div class="container-fluid mt-5">
    <div class="mx-auto" style="width: 450px;">
        <div class="text-center">
            <h3>You paid {{$order->total}}$</h3>
            <span>Please wait while we prepare your order.</span>
        </div>
        <div class="mt-5">
            <h6 class="text-center">Order Summary</h6>
            <table class="table table-borderless">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->detail as $order)
                    <tr>
                        <td>{{ $order['product_id'] }}</td>
                        <td>${{ $order['price'] }}</td>
                        <td>{{$order['qty']}}</td>
                        <td>${{$order['price'] * $order['qty']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
