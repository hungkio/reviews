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

<script>

    function init(){
        var googleFontsLink = document.createElement('link');
        googleFontsLink.href = 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap';
        googleFontsLink.rel = 'stylesheet';
        document.head.appendChild(googleFontsLink);

        var fontAwesomeLink = document.createElement('link');
        fontAwesomeLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css';
        fontAwesomeLink.rel = 'stylesheet';
        document.head.appendChild(fontAwesomeLink);

        var style = document.createElement('style');
        style.innerHTML = `
                .carousel-container {
            font-family: "Montserrat", sans-serif;
            background-color: #fff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 50px auto;
            width: 80%;
            overflow: hidden;
            position: relative;
        }

        .carousel {
            display: flex;
            overflow: hidden;
            width: 100%;
            position: relative;
        }

        .carousel-items {
            width: 100%;
            display: flex;
            transition: transform 0.5s ease;
        }

        .carousel-item {
            min-width: 33.33%;
            box-sizing: border-box;
            padding: 5px;

        }

        .carousel-item .item-content {
            overflow: hidden;
            border: thin solid hsla(0, 0%, 90%, 1);
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            text-align: left;
        }

        .carousel-button {
            width: 30px;
            height: 30px;
            border-radius: 30px;
            background-color: rgba(100, 100, 100, 0.5);
            color: white;
            border: none;

            cursor: pointer;
        }

        .carousel-button:disabled {

            background-color: #cccccc;
        }

        .carousel-button.prev {
            position: absolute;
            left: 0;
            z-index: 10
        }

        .carousel-button.next {
            position: absolute;
            right: 0;
            z-index: 10
        }

        .action-btn {
            color: black;
        }

        .fa-star {
            color: #fbbf24
        }

        .fa-star-o {
            color: #ccc
        }
            `;
        document.head.appendChild(style);
    }


    const items = [
        {
            name: "Joshhhh",
            star: 1,
            review: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. "
        },
        {name: "Kabin", star: 2, review: "Lorem Ipsum is simply dummy text of the printing and typesetting industry"},
        {
            name: "David",
            star: 3,
            review: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"
        },
        {
            name: "Robin",
            star: 4,
            review: "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."
        },
        {
            name: "Lady",
            star: 5,
            review: "When an unknown printer took a galley of type and scrambled it to make a type specimen book."
        },
        {
            name: "Katty",
            star: 4,
            review: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."
        },
        {name: "James", star: 3, review: "Lorem Ipsum is simply dummy text of the printing and typesetting industry"},
    ];

    let currentIndex = 0;
    const itemsPerView = 3;
    const carouselItemsContainer = document.querySelector('.carousel-items');

    function renderItems() {
        carouselItemsContainer.innerHTML = '';
        for (let i = currentIndex; i < items.length; i++) {
            if (i >= items.length) break;
            const item = items[i];
            const itemElement = document.createElement('div');
            itemElement.classList.add('carousel-item');
            itemElement.innerHTML = `
                    <div class="item-content">
                        <div style="display: flex; align-items: center; width: 100%">
                            <img src="https://i.insider.com/64c7a2c9048ff200190deaf5?width=800&format=jpeg&auto=webp" alt="Avatar" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px; object-fit: cover">
                            <div style="flex-grow: 5; text-align: left">
                                <p style="font-size: 1rem; font-weight: 500">${item.name}</h3>
                            </div>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b9/2023_Facebook_icon.svg" alt="Avatar" style="width: 20px; height: 20px; border-radius: 50%; margin-right:  10px; object-fit: cover">

                        </div>
                        ${[...Array(5)].map((_, idx) => `<i class="fa fa-solid fa-star${idx < item.star ? '' : '-o'}"></i>`).join('')}
                    <p style="color: grey; font-size: 0.8rem">${item.review}</p>
                        </div>

                    </div>
                `;
            carouselItemsContainer.appendChild(itemElement);
        }
    }

    function moveCarousel(direction) {
        currentIndex += direction;
        if (currentIndex < 0) {
            currentIndex = items.length - itemsPerView;
        } else if (currentIndex > items.length - itemsPerView) {
            currentIndex = 0;
        }
        const offset = -currentIndex * (100 / itemsPerView);
        carouselItemsContainer.style.transform = `translateX(${offset}%)`;
    }

    function startAutoPlay() {
        setInterval(() => {
            moveCarousel(1);
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        init();
        renderItems();
        startAutoPlay()
    });
</script>
</body>
</html>
