function initStyleAndScript() {
    var preconnect1 = document.createElement("link");
    preconnect1.rel = "preconnect";
    preconnect1.href = "https://fonts.googleapis.com";

    var preconnect2 = document.createElement("link");
    preconnect2.rel = "preconnect";
    preconnect2.href = "https://fonts.gstatic.com";
    preconnect2.crossOrigin = true;

    document.head.appendChild(preconnect1);
    document.head.appendChild(preconnect2);

    const cssLinks = [
        {
            href: 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap',
            rel: 'stylesheet'
        },
        {
            href: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css',
            rel: 'stylesheet'
        },
        {
            href: 'https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css',
            rel: 'stylesheet'
        }
    ];

    function addCSS(link) {
        const linkElement = document.createElement('link');
        linkElement.href = link.href;
        linkElement.rel = link.rel;
        document.head.appendChild(linkElement);
    }

    cssLinks.forEach(addCSS);
}

function initLayout() {

    var container = document.querySelector('.container');
    var row = document.createElement('div');
    row.className = 'row';
    container.appendChild(row);

    for (var i = 0; i < 3; i++) {
        var col = document.createElement('div');
        col.className = 'col-md-4';
        col.innerHTML = '<div class="d-flex flex-column"></div>';
        row.appendChild(col);
    }
}

function renderReviews(reviews) {
    var columns = document.querySelectorAll('.col-md-4');
    var columnIndex = 0;
    reviews.forEach(function (review) {
        let stars = ''
        for (var i = 0; i < review.star; i++) {
            stars += '<i class="icon-star" style="color: #fbbf24; font-size: 20px; margin-right: 3px"></i>';
        }
        var reviewHTML = `
            <div class="mt-3" style="border: 1px solid #e6e6e6; border-radius: 5px; padding: 20px; background-color: #fff; margin-bottom: 20px;">
                <div class="d-flex align-items-center mt-2">
                    <div style="background-size: cover; width: 40px; height: 40px; border-radius: 40px">
                        <img style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px; object-fit: cover" src="${review.avatar}">
                    </div>
                    <div style="font-family:  'Montserrat', sans-serif; margin-left: 20px; text-transform: uppercase; font-weight: 600; font-size: 1em; color: #737272;">
                        ${review.name}
                    </div>
                    <img style="width: 20px; height: 20px; margin-left: auto;" src="${review.social}">
                </div>
                <i class="fa fa-star-o"></i>
                <div class="d-flex" style="margin-top: 20px">${stars}</div>
                <div class="mt-2" style="font-size: 13px; color: grey; font-family: 'Montserrat', sans-serif">${review.review}</div>
            </div>`;
        columns[columnIndex].innerHTML += reviewHTML;
        columnIndex = (columnIndex + 1) % columns.length;
    });
}

function getAllPublicReviews(){
    fetch('https://reviews.stage.n-framescorp.com/get-reviews', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: '',
    })
        .then(response => response.json())
        .then(data => {
            console.log('success:', data);
            return renderReviews(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

document.addEventListener("DOMContentLoaded", function() {
    initStyleAndScript();
    initLayout();
    getAllPublicReviews()
});

