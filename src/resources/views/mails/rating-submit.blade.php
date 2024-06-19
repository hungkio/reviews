<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Rating Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        body {
            text-align: center;
            line-height: 80vh;
            font-family: 'Roboto';
            margin: 0;
            padding: 0;
        }

        @keyframes confetti-slow {
            0% {
                transform: translate3d(0, 0, 0) rotateX(0) rotateY(0);
            }

            100% {
                transform: translate3d(25px, 105vh, 0) rotateX(360deg) rotateY(180deg);
            }
        }

        @keyframes confetti-medium {
            0% {
                transform: translate3d(0, 0, 0) rotateX(0) rotateY(0);
            }

            100% {
                transform: translate3d(100px, 105vh, 0) rotateX(100deg) rotateY(360deg);
            }
        }

        @keyframes confetti-fast {
            0% {
                transform: translate3d(0, 0, 0) rotateX(0) rotateY(0);
            }

            100% {
                transform: translate3d(-50px, 105vh, 0) rotateX(10deg) rotateY(250deg);
            }
        }

        .container {
            width: 100vw;
            height: 100vh;
            background: #ffffff;
            border: 1px solid white;
            display: fixed;
            top: 0px;
        }

        .confetti-container {
            perspective: 700px;
            position: absolute;
            overflow: hidden;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .confetti {
            position: absolute;
            z-index: 1;
            top: -10px;
            border-radius: 0%;

            &--animation-slow {
                animation: confetti-slow 2.25s linear 1 forwards;
            }

            &--animation-medium {
                animation: confetti-medium 1.75s linear 1 forwards;
            }

            &--animation-fast {
                animation: confetti-fast 1.25s linear 1 forwards;
            }
        }





        /* Checkmark */
        .checkmark-circle {
            width: 150px;
            height: 150px;
            position: relative;
            display: inline-block;
            vertical-align: top;
            margin-left: auto;
            margin-right: auto;
        }

        .checkmark-circle .background {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #00C09D;
            position: absolute;
        }

        .checkmark-circle .checkmark {
            border-radius: 5px;
        }

        .checkmark-circle .checkmark.draw:after {
            -webkit-animation-delay: 100ms;
            -moz-animation-delay: 100ms;
            animation-delay: 100ms;
            -webkit-animation-duration: 3s;
            -moz-animation-duration: 3s;
            animation-duration: 3s;
            -webkit-animation-timing-function: ease;
            -moz-animation-timing-function: ease;
            animation-timing-function: ease;
            -webkit-animation-name: checkmark;
            -moz-animation-name: checkmark;
            animation-name: checkmark;
            -webkit-transform: scaleX(-1) rotate(135deg);
            -moz-transform: scaleX(-1) rotate(135deg);
            -ms-transform: scaleX(-1) rotate(135deg);
            -o-transform: scaleX(-1) rotate(135deg);
            transform: scaleX(-1) rotate(135deg);
            -webkit-animation-fill-mode: forwards;
            -moz-animation-fill-mode: forwards;
            animation-fill-mode: forwards;
        }

        .checkmark-circle .checkmark:after {
            opacity: 1;
            height: 75px;
            width: 37.5px;
            -webkit-transform-origin: left top;
            -moz-transform-origin: left top;
            -ms-transform-origin: left top;
            -o-transform-origin: left top;
            transform-origin: left top;
            border-right: 15px solid white;
            border-top: 15px solid white;
            border-radius: 2.5px !important;
            content: '';
            left: 25px;
            top: 75px;
            position: absolute;
        }

        @-webkit-keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 37.5px;
                opacity: 1;
            }

            40% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }

            100% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }
        }

        @-moz-keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 37.5px;
                opacity: 1;
            }

            40% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }

            100% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }
        }

        @keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 37.5px;
                opacity: 1;
            }

            40% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }

            100% {
                height: 75px;
                width: 37.5px;
                opacity: 1;
            }
        }



        .submit-btn {
            height: 45px;
            width: 200px;
            font-size: 15px;
            background-color: #00c09d;
            border: 1px solid #00ab8c;
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px 0 rgba(87, 71, 81, .2);
            cursor: pointer;
            transition: all 2s ease-out;
            transition: all .2s ease-out;
        }

        .submit-btn:hover {
            background-color: #2ca893;
            transition: all .2s ease-out;
        }
    </style>
</head>
<?php
$maxStars = 5;
$emojis = ["😡", "😟", "😐", "😊", "😍"];
$rating_style = isset($rating_style) ? $rating_style : "stars";
?>

<body>
    <div class="js-container container" style="top:0px !important;">
        <h1>
            Thank you for your review
        </h1>
    </div>



    <div class="container" style="background-color: <?php echo $background_color; ?>; display: none">
        <form action="{{ route('webform.store') }}" method="POST" enctype="multipart/form-data" class="form-wrapper">
            @csrf
            <input type="hidden" name="payment_id" value="{{$payment_id ?? ''}}">
            <input type="hidden" name="payment_intent_id" value="{{$payment_intent_id ?? ''}}">
            <h1>Rate Us</h1>
            <?php echo $email_body; ?>
            <div class="rating" style="justify-content: center!important; align-items: center!important; width: 100%!important; text-align: center!important">
                <?php
                if ($rating_style == 'stars') {
                    for ($i = 1; $i <= $maxStars; $i++) {
                        echo '<div class="rating" style="justify-content: center!important; align-items: center!important; width: 100%!important; text-align: center!important">';
                        echo '<input type="radio" id="star' . $i . '" name="star" value="' . $i . '" ' . ($star == $i ? 'checked' : '') . '>';
                        for ($j = 1; $j <= $i; $j++) {
                            echo '<label for="star' . $i . '" title="' . $i . ' star">&#9733;</label>';
                        }
                        echo '</div>';
                    }
                } else {
                    for ($i = 1; $i <= $maxStars; $i++) {
                        echo '<div class="rating" style="justify-content: center!important; align-items: center!important; width: 100%!important; text-align: center!important">';
                        echo '<input type="radio" id="star' . $i . '" name="star" value="' . $i . '" ' . ($star == $i ? 'checked' : '') . '>';
                        echo '<label for="star' . $i . '" title="' . $i . ' star">' . $emojis[$i - 1] . '</label>';
                        echo '</div>';
                    }
                }
                ?>
            </div>

            <div class="feedback-wrapper">
                <h3 for="review">Feedback:</h3>
                <textarea id="review" placeholder="Enter your feedback" value="{{$review ?? ''}}" name="review" rows="4" cols="50">{{ $review ?? '' }}</textarea><br>
            </div>
            <button class="btn-submit" type="submit" id="submit-review">Submit</button>
        </form>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var submitButton = document.getElementById("submit-review");
        if (submitButton) {
            setTimeout(function() {
                submitButton.click();
            }, 2000);
        }
    });
</script>

</html>