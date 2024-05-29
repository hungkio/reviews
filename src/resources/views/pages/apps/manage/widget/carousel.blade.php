<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Badge</title>
    <style>
        body {
            font-family: "Montserrat", sans-serif;
        }

        .badge {
            display: flex;
            align-items: center;
            border: thin solid #eee;
            border-radius: 10px;
            padding: 10px;
            overflow: hidden;
            width: 100%;
            height: 100%
        }

        .badge-left {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 25%;
            height: 100%;
            padding: 10px;

        }

        .badge-right {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 10px;
            width: 75%;
        }

        .stars {
            color: #fc4938;
            font-size: 1.2em;
        }

        .reviews {
            font-size: 0.9em;
            color: #555;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div style="width: 250px; height: 50px;">
    <div class="badge">
        <div class="badge-left">
            <div style="width: 100%; height: 100%; background-color: black; color: white; display: flex;
            flex-direction: column; text-align: center; border-radius: 8px;
            justify-content: center; font-size: 1.3rem">
                5.0
            </div>

        </div>
        <div class="badge-right">
            <div class="stars">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </div>
            <div class="reviews">
                from 225 testimonials
            </div>
        </div>
    </div>
</div>
</body>
</html>
