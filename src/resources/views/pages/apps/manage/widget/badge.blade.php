<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div id="import_badge" style="width: 250px; height: 50px;"></div>
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
                #import_badge {
            font-family: "Montserrat", sans-serif;
        }

        #import_badge .badge {
            display: flex;
            align-items: center;
            border: thin solid #eee;
            border-radius: 10px;
            padding: 10px;
            overflow: hidden;
            width: 100%;
            height: 100%
        }

        #import_badge .badge-left {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 25%;
            height: 100%;
            padding: 10px;

        }

        #import_badge .badge-right {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 10px;
            width: 75%;
        }

        #import_badge .stars {
            color: #fc4938;
            font-size: 1.2em;
        }

        #import_badge .reviews {
            font-size: 0.9em;
            color: #555;
            margin-top: 5px;
        }
            `;
        document.head.appendChild(style);
    }

    function showBadge(data){
        let stars = ''
        for (var i = 0; i < 3; i++) {
            stars += '<i class="fa fa-star" style="margin-right: 3px"></i>';
        }
        var reviewHTML = `<div class="badge">
            <div class="badge-left">
                <div style="width: 100%; height: 100%; background-color: black; color: white; display: flex;
                flex-direction: column; text-align: center; border-radius: 8px;
                justify-content: center; font-size: 1.3rem">
                    ${data.star}
                </div>
            </div>
            <div class="badge-right">
                <div class="stars">
                    ${stars}
                </div>
                <div class="reviews">
                    from ${data.total} testimonials
                </div>
            </div>
        </div>`;

        var get_elememt = document.getElementById('import_badge');
        get_elememt.innerHTML = reviewHTML;
    }

    document.addEventListener("DOMContentLoaded", function () {
        init();
        showBadge({star: '5.0', total: 223});
    });
</script>
</body>
</html>
