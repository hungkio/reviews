<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        .order-container {
            width: 100%;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .order-container:nth-child(even) {
            background-color: #f1f1f1;
        }

        .order-field {
            margin: 5px 0;
        }

        .order-field span {
            font-weight: bold;
        }
    </style>
</head>

<body>
<h2>Request Destinations</h2>

<div class="order-container">
    <div class="order-field"><span class="font-weight-bold">Order ID:</span> {{$data['order-id'] ?? ''}}</div>
    <div class="order-field"><span class="font-weight-bold">Name:</span> {{$data['name'] ?? ''}}</div>
    <div class="order-field"><span class="font-weight-bold">Phone:</span> {{$data['phone'] ?? ''}}</div>
    <div class="order-field"><span class="font-weight-bold">Address:</span> {{$data['address'] ?? ''}}</div>
    <div class="order-field"><span class="font-weight-bold">Email:</span> {{$data['email'] ?? ''}}</div>
    <div class="order-field"><span class="font-weight-bold">Content:</span> {{$data['content'] ?? ''}}</div>
</div>
</body>

</html>
