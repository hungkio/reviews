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

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            align-items: center;
            padding-right: 15px;
            font-size: 1.5rem
            }

        .rating label {
            font-size: 1.5rem;
            color: #ffc700;
            cursor: pointer;
            }

        .rating input {
            margin-top: 3px;
            }

    </style>
</head>
<?php
$maxStars = 5;
$emojis = ["😍", "😊", "😐", "😟", "😡"];
$background_color = "rgb(14, 119, 255, 0.1)";
?>

<body>
<div style="width: 100%; height: auto; background-color: <?php echo $background_color; ?>; padding: 50px 0">
    <form action="{{ route('webform.show') }}" method="GET" style="width: 100%; background: white; max-width: 568px; height: auto; margin: 0 auto; text-align: center;
           box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px; padding: 20px 15px; border-radius: 10px">
        <input type="hidden" name="payment_id" value="{{$data->payment_intent_id ?? ''}}">
        <h1 style="color: #443c68">Rate Us</h1>
        <p style="font-size: 14px; font-weight: 500">How was your experience using our application? Your rating
            matter!</p>
        <div class="rating">
            <?php
            if ($rating_style == 'stars') {
                for ($i = 1; $i <= $maxStars; $i++) {
                    echo '<div class="rating">';
                    for ($j = 1; $j <= $i; $j++) {
                        echo '<label for="star' . $i . '" title="' . $i . ' star">&#9733;</label>';
                    }
                    echo '<input type="radio" id="star' . $i . '" name="star" value="' . $i . '">';

                    echo '</div>';
                }
            } else {
                for ($i = 1; $i <= $maxStars; $i++) {
                    echo '<div class="rating">';
                    echo '<label for="star' . $i . '" title="' . $i . ' star">' . $emojis[$i - 1] . '</label>';
                    echo '<input type="radio" id="star' . $i . '" name="star" value="' . $i . '">';

                    echo '</div>';
                }
            }
            ?>
        </div>

        <div style="width: 100%; text-align: left">
            <h3 for="review" style="text-align: left; font-weight: 600">Feedback:</h3>
            <textarea id="review" placeholder="Enter your feedback" name="review" rows="4" cols="50" style="font-family: 'Montserrat', sans-serif; width: 100%; height: 120px; margin-bottom: 20px;
            margin-top: 10px; padding: 15px; border: none; background-color: #0e77ff1a; outline: none; border-radius: 5px; resize: vertical; font-size: 0.7rem; box-sizing: border-box;"></textarea><br>
        </div>
        <button
            style="font-family: 'Montserrat', sans-serif; padding: 10px 55px; border: none; border-radius: 20px; background-color: #0e77ff; color: white; font-size: 0.8rem; cursor: pointer;"
            class="btn-submit" type="submit">Submit
        </button>
    </form>
</div>
</body>

</html>
