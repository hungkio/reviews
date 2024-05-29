<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: "Montserrat", sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .rating-container{
            text-align: center;
            padding: 0 10px;
        }

        .rating-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .stars {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .star {
            font-size: 2.5em;
            cursor: pointer;
            color: #e6eaf2;
            transition: color 0.3s, transform 0.3s;
        }

        .star:hover,
        .star.selected {
            color: #f39c12;
            transform: scale(1.1);
        }

        textarea {
            width: 100%;
            height: 120px;
            margin-bottom: 20px;
            padding: 15px;
            border: none;
            background-color: #f2f4f8c4;
            outline: none;
            border-radius: 5px;
            resize: vertical;
            font-size: 0.7rem;
            box-sizing: border-box;
        }

        button {
            padding: 10px 55px;
            border: none;
            border-radius: 20px;
            background-color: #0e77ff;
            color: white;
            font-size: 0.8rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
    </style>
</head>
<body>
<div class="rating-container">
    <div class="stars">
        <span class="star" data-value="1">&#9733;</span>
        <span class="star" data-value="2">&#9733;</span>
        <span class="star" data-value="3">&#9733;</span>
        <span class="star" data-value="4">&#9733;</span>
        <span class="star" data-value="5">&#9733;</span>
    </div>
    <textarea id="review" placeholder="Enter your review"></textarea>
    <button onclick="submitReview()">Submit</button>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    var csrfToken = "{{ csrf_token() }}";
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll('.star');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                clearSelection();
                star.classList.add('selected');
                const rating = star.getAttribute('data-value');
                highlightStars(rating);
            });
        });

        function clearSelection() {
            stars.forEach(star => {
                star.classList.remove('selected');
                star.style.color = '#ccc';
            });
        }

        function highlightStars(rating) {
            for (let i = 0; i < rating; i++) {
                stars[i].style.color = '#f39c12';
            }
        }
    });

    function submitReview() {
        const rating = document.querySelector('.star.selected')?.getAttribute('data-value') || 0;
        const review = $("#review").val();
        const data_send = {
            'rating': rating,
            'review': review
        }

        $.ajax({
            url: "{{'/save-review'}}",
            data: data_send,
            method: 'POST',
            headers: {
                'X-CSRF-Token': csrfToken
            },
            success: function (res) {
                button.removeAttribute("data-kt-indicator");
                Swal.fire({
                    text: res.message,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            },
            error: function (err) {
                button.removeAttribute("data-kt-indicator");
                Swal.fire({
                    text: "Sorry, looks like there are some errors detected, please try again.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        })
    }
</script>
</body>
</html>
