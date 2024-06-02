<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carousel</title>
</head>
<body>
<div class="carousel-container">
    <button class="carousel-button prev" onclick="moveCarousel(-1)">
        <i class="action-btn fa fa-solid fa-arrow-left"></i>
    </button>
    <div class="carousel">
        <div class="carousel-items">
        </div>
    </div>
    <button class="carousel-button next" onclick="moveCarousel(1)">
        <i class="action-btn fa fa-solid fa-arrow-right"></i>
    </button>
</div>

<script src="https://reviews.stage.n-framescorp.com/assets/plugins/custom/widget/carousel.js"></script>
</body>
</html>
