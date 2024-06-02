<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Rating Form</title>
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            align-items: center;
            padding-right: 15px
        }

        .rating label {
            font-size: 2rem;
            color: #ffc700;
            cursor: pointer;
        }

        .rating input{
            margin-top: 3px;
        }

    </style>
</head>
<?php
$maxStars = 5;
$emojis = ["😡", "😟", "😐", "😊", "😍"];
$rating_style = 'stars';
?>

<body>
    <form action="{{ route('webform.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="email" value="{{$email ?? ''}}">
        <input type="hidden" name="customer_id" value="{{$customer_id ?? ''}}">
        <input type="hidden" name="account_id" value="{{$account_id ?? ''}}">
        <input type="hidden" name="id_update" value="{{$id_update ?? ''}}">

        <label for="review">Feedback:</label><br>
        <textarea id="review" name="review" rows="4" cols="50" value="{{$review ?? ''}}">{{ $review ?? '' }}</textarea><br>

        <div class="rating">
            <?php
            if($rating_style == 'stars'){
                for ($i = 1; $i <= $maxStars; $i++) {
                    echo '<div class="rating">';
                    echo '<input type="radio" id="star' . $i . '" name="star" value="' . $i . '" ' . ($star == $i ? 'checked' : '') . '>';
                    for ($j = 1; $j <= $i; $j++) {
                        echo '<label for="star' . $i . '" title="' . $i . ' star">&#9733;</label>';
                    }
                    echo '</div>';
                }
            }else{
                for ($i = 1; $i <= $maxStars; $i++) {
                    echo '<div class="rating">';
                    echo '<input type="radio" id="star' . $i . '" name="star" value="' . $i . '" ' . ($star == $i ? 'checked' : '') . '>';
                    echo '<label for="star' . $i . '" title="' . $i . ' star">' . $emojis[$i - 1] . '</label>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <button type="submit">Submit</button>
    </form>
</body>

</html>