<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Rating Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <style>
        * {
            font-family: 'Montserrat', sans-serif !important;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .rating {
            display: flex;
            flex-direction: row;
            justify-content: center!important;
            align-items: center!important;
            padding-right: 15px;
            font-size: 1.5rem;
        }

        .rating label {
            font-size: 1.5rem;
            color: #ffc700;
            cursor: pointer;
        }

        .rating input {
            margin-top: 3px;
        }

        .container {
            width: 100%;
            height: auto;
            padding: 50px 0;
        }

        .form-wrapper {
            width: 100%;
            background: white;
            max-width: 568px;
            height: auto;
            margin: 0 auto;
            text-align: center;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
            padding: 20px 15px;
            border-radius: 10px;
        }

        .form-wrapper h1 {
            color: #443c68;
        }

        .feedback-wrapper {
            width: 100%;
            text-align: left;
        }

        .feedback-wrapper h3 {
            text-align: left;
            font-weight: 600;
        }

        .feedback-wrapper textarea {
            font-family: 'Montserrat', sans-serif;
            width: 100%;
            height: 120px;
            margin-bottom: 20px;
            margin-top: 10px;
            padding: 15px;
            border: none;
            background-color: #0e77ff1a;
            outline: none;
            border-radius: 5px;
            resize: vertical;
            font-size: 0.7rem;
            box-sizing: border-box;
        }

        .btn-submit {
            font-family: 'Montserrat', sans-serif;
            padding: 10px 55px;
            border: none;
            border-radius: 20px;
            background-color: #0e77ff;
            color: white;
            font-size: 0.8rem;
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .rating {
                font-size: 1rem;
                padding-right: 0;
            }

            .rating label {
                font-size: 1rem;
            }

            .form-wrapper {
                padding: 15px;
                width: auto !important;
            }

            .feedback-wrapper textarea {
                font-size: 0.8rem;
                height: 100px;
            }

            .btn-submit {
                padding: 10px 30px;
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<?php
$maxStars = 5;
$emojis = ["😍", "😊", "😐", "😟", "😡"];
$background_color = isset($data->color) ? $data->color : "rgb(14, 119, 255, 0.1)";
$email_body = isset($reviewRequests->email_body) ? $reviewRequests->email_body : "";
$rating_style = isset($reviewRequests->rating_style) ? $reviewRequests->rating_style : "stars";
?>

<body>
<div class="container" style="background-color: <?php echo $background_color; ?>;">
    <form action="{{ route('webform.show') }}" method="GET" class="form-wrapper">
        <input type="hidden" name="rating_style" value="{{$rating_style ?? 'stars'}}">
        <input type="hidden" name="payment_id" value="{{$payment->payment_intent_id ?? ''}}">
        <input type="hidden" name="email_body" value="{{$email_body ?? ''}}">
        <input type="hidden" name="background_color" value="{{$background_color ?? ''}}">
        <h1>Rate Us</h1>
        <?php echo $email_body; ?>
        <div class="rating" style="justify-content: center;">
            <?php
            if ($rating_style == 'stars') {
                for ($i = 1; $i <= $maxStars; $i++) {
                    echo '<div class="rating" style="justify-content: center!important;">';
                    echo '<input type="radio" id="star' . $i . '" name="star" value="' . $i . '">';
                    for ($j = 1; $j <= $i; $j++) {
                        echo '<label for="star' . $i . '" title="' . $i . ' star">&#9733;</label>';
                    }
                    echo '</div>';
                }
            } else {
                for ($i = 1; $i <= $maxStars; $i++) {
                    echo '<div class="rating" style="justify-content: center!important;">';
                    echo '<input type="radio" id="star' . $i . '" name="star" value="' . $i . '">';
                    echo '<label for="star' . $i . '" title="' . $i . ' star">' . $emojis[$i - 1] . '</label>';
                    echo '</div>';
                }
            }
            ?>
        </div>

        <div class="feedback-wrapper">
            <h3 for="review">Feedback:</h3>
            <textarea id="review" placeholder="Enter your feedback" name="review" rows="4" cols="50"></textarea><br>
        </div>
        <button class="btn-submit" type="submit">Submit</button>
    </form>
</div>
</body>

</html>
