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
<div id="toast">
    <button class="close-btn" onclick="closeToast()">&times;</button>
</div>

<script>
    const reviews = [
        {
            name: 'Robin Hamston',
            social: 'https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/x-social-media-black-icon.png',
            avatar: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQoPyPi1LdCO51Oc9078ys0pasPJNxUPjrUNMDoiii6Cxqw3InmBzJGrtbmXFC2Yaha1hM&usqp=CAU',
            review: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
            star: 3
        },
        {
            name: 'Katty Prompenk',
            social: 'https://upload.wikimedia.org/wikipedia/commons/b/b9/2023_Facebook_icon.svg',
            avatar: 'https://images2.thanhnien.vn/528068263637045248/2023/8/30/1-1693385246169701996465.jpg',
            review: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            star: 5
        },
        {
            name: 'Jonny Mothonary',
            social: 'https://cdn4.iconfinder.com/data/icons/logos-brands-7/512/google_logo-google_icongoogle-512.png',
            avatar: 'https://wp.technologyreview.com/wp-content/uploads/2023/12/h_00000222725138_mainV.jpg',
            review: ' Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            star: 5
        }
    ];

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
                #toast {
                    visibility: hidden;
                    /*border: thin solid #e5e7eb;*/
                    border: none;
                    border-radius: 10px;
                    width: 400px;
                    margin-left: 15px;
                    background-color: #fff;
                    text-align: center;
                    position: fixed;
                    z-index: 1;
                    left: 15px;
                    bottom: 30px;
                    font-size: 17px;
                    font-family: "Montserrat", sans-serif;
                    box-shadow: 10px 20px 100px rgba(0, 0, 0, 0.1), 0 10px 20px rgba(0, 0, 0, 0.07);
                }

                #toast.show {
                    visibility: visible; /* Hiển thị toast */
                    -webkit-animation: fadein 0.5s;
                    animation: fadein 0.5s;
                }

                @-webkit-keyframes fadein {
                    from {
                        bottom: 0;
                        opacity: 0;
                    }
                    to {
                        bottom: 30px;
                        opacity: 1;
                    }
                }

                @keyframes fadein {
                    from {
                        bottom: 0;
                        opacity: 0;
                    }
                    to {
                        bottom: 30px;
                        opacity: 1;
                    }
                }

                .close-btn {
                    border-radius: 20px;
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background: none;
                    border: none;
                    color: white;
                    font-size: 15px;
                    cursor: pointer;
                }

                .close-btn:hover {
                    background: #d6d6d6;
                }

                .review {
                    margin: 5px 0;
                    min-height: 70px;
                    font-size: 0.8rem;
                    text-overflow: ellipsis;
                    overflow: hidden;
                    display: -webkit-box;
                    -webkit-line-clamp: 5;
                    -webkit-box-orient: vertical;
                    white-space: normal;
                    color: black
                }
            `;
        document.head.appendChild(style);
    }
    function renderReview(active_review) {
        var stars = "";
        for (var i = 0; i < active_review.star; i++) {
            stars += '<i class="fa fa-star"></i> ';
        }
        return`
      <div style="display: flex">
        <div style="width: 33.33%; height: 150px; ">
            <div style="width: 100%; height: 100%; ">
            <img style="object-fit: cover; width: 100%; height: 100%; border-top-left-radius: 9px; border-bottom-left-radius: 10px" src="${active_review.avatar}" style="width: 100%; height: auto;">
        </div>
            </div>
        <div style="width: 66.66%; padding: 10px; text-align: left">
            <div class="rating" style="color: #fa7024; font-size: 1.2rem">
            	${stars}
            </div>
            <div class="review">${active_review.review}</div>
            <div style="font-size: 0.7rem; color: #707684; display: flex; align-items: center;">
    <span>${active_review.name}</span>
    <div style="width: 15px; height: 15px; border-radius: 3px; overflow: hidden; margin-left: 5px;">
        <img style="object-fit: cover; width: 100%; height: 100%;" src="${active_review.social}">
    </div>
</div>
    </div>
    `;
    }

    let index = 1;
    let close = false;

    let interval = setInterval(() => {
        if (index < reviews.length && !close) {
            curent_review = reviews[index];
            showToast(renderReview(curent_review));
            index++;
            if (index >= reviews.length) {
                index = 0;
            }
        }
    }, 5000);

    function showToast(htmlContent) {
        var toast = document.getElementById("toast");
        toast.innerHTML = `<button class="close-btn" onclick="closeToast()">&times;</button>` + htmlContent;
        toast.className = "show";
    }

    function closeToast() {
        close = true;
        var toast = document.getElementById("toast");
        toast.className = toast.className.replace("show", "");
    }

    document.addEventListener("DOMContentLoaded", function () {
        init();
        showToast(renderReview(reviews[0]));
    });
</script>
</body>
</html>
