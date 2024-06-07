<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom HTML Toast Example with Close Button</title>
    <style>
        .fullscreen {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
        .fullscreen p {
            font-size: 24px;
            color: #939191;
        }
    </style>
</head>
<body>
<div class="fullscreen">
    <p>Your website</p>
</div>
<div id="toast"><button class="close-btn" onclick="closeToast()">&times;</button></div>
<script src="https://reviews.stage.n-framescorp.com/assets/plugins/custom/widget/notification.js"></script>
{{--<script src="{{ asset('assets/plugins/custom/widget/notification.js') }}"></script>--}}
</body>
</html>
