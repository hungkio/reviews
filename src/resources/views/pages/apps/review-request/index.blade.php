<x-default-layout>

    @section('title')
        Review Request
    @endsection

    <style>
        #editor-container {
            height: 350px;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100%;
        }

        .editor,
        .preview {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        .editor {
            border: 1px solid #ccc;
        }

        .preview {
            border: 1px solid #ccc;
            background: #f9f9f9;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        textarea {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
            width: 100%;
            height: calc(100% - 80px);
        }

        iframe {
            border: none;
            flex: 1;
            width: 100%;
            height: 100%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .device-icons button {
            margin-left: 10px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 10px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .ql-editor p img {
            max-width: 100%;
            height: 150px;
        }

        /* .star-rating {
            font-size: 0;
            white-space: nowrap;
            display: inline-block;
            width: 125px;
            height: 25px;
            overflow: hidden;
            position: relative;
            line-height: 25px;
        }
        .star-rating a {
            text-decoration: none;
            font-size: 25px;
            color: #ccc;
            margin: 0 2px;
            cursor: pointer;
        }
        .star-rating .rated {
            color: gold;
        }
        .emoji-rating {
            font-size: 0;
            white-space: nowrap;
            display: inline-block;
            width: auto;
            height: 50px;
            overflow: hidden;
            position: relative;
            line-height: 50px;
        }
        .emoji-rating a {
            text-decoration: none;
            font-size: 40px;
            margin: 0 5px;
            cursor: pointer;
        }
        .emoji-rating a:hover {
            transform: scale(1.2);
        }
        .emoji-rating .selected {
            opacity: 0.7;
        } */
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


    <body>
    <div class="container">
        <div class="editor mr-2">
            <div class="add-request mb-2">
                <div id="list-template" style="display: flex; float: left">

                </div>
                <a onclick="setNewForm()" href="javascript:;" class="btn btn-primary btn-add">
                    Add
                </a>
            </div>
            <input type="hidden" name="rating" id="rating" value="0">
            <div class="d-flex justify-content-between">
                <div class="form-group">
                    <label for="interval">Interval (after payment)</label>
                    <div class="d-flex">
                        <input type="number" class="form-control" id="interval-date" style="margin-right: 5px;"
                               name="interval-date">
                        <select id="interval-type" class="form-select" name="interval-type">
                            <!-- Đã sửa "-type" thành "interval-type" -->
                            <option value="days">Days</option>
                            <option value="months">Months</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mr-2 ml-2">
                    <label for="rating-style">Rating Style</label>
                    <select onchange="updatePreview()" id="rating-style" class="form-select" name="rating-style">
                        <option value="stars">Stars</option>
                        <option value="emoji">Emoji</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <input onkeydown="updatePreview()" type="text" class="form-control" id="email-subject"
                       name="email-subject" placeholder="Email Subject">
            </div>
            <div id="editor-container"></div>

            <button onclick="submitForm()" type="button" class="btn btn-primary mt-10" id="submit">
                    <span class="indicator-label">
                        Save
                    </span>
                <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
            </button>
        </div>
        <div class="preview">
            <header>
                <div class="device-icons">
                    <button class="btn btn-secondary mr-3" id="mobile-view" onclick="switchView('mobile')">📱 Mobile
                    </button>
                    <button class="btn btn-secondary mf-2" id="desktop-view" onclick="switchView('desktop')">💻 Desktop
                    </button>
                </div>
            </header>
            <iframe id="preview-frame" style="height: 65vh;"></iframe>
        </div>
    </div>


    <script>
        // function rateStar(rating) {
        //     const stars = document.querySelectorAll('.star-rating a');
        //     stars.forEach((star, index) => {
        //         if (index < rating) {
        //             star.classList.add('rated');
        //         } else {
        //             star.classList.remove('rated');
        //         }
        //     });
        //     document.getElementById('rating').value = rating;
        // }
        // function rateEmoji(rating) {
        //     const emojis = document.querySelectorAll('.emoji-rating a');
        //     emojis.forEach((emoji, index) => {
        //         if (index == rating - 1) {
        //             emoji.classList.add('selected');
        //         } else {
        //             emoji.classList.remove('selected');
        //         }
        //     });
        //     document.getElementById('rating').value = rating;
        // }
        let csrfToken = "{{ csrf_token() }}";
        let button = document.querySelector("#submit");
        const ratingHTMLStar = `<div style=" text-align: center; padding: 0 10px;">
                                    <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                                        <span style=" font-size: 2.5em; cursor: pointer; color: #f39c12;" data-value="1">&#9733;</span>
                                        <span style=" font-size: 2.5em; cursor: pointer; color: #f39c12;" data-value="1">&#9733;</span>
                                        <span style=" font-size: 2.5em; cursor: pointer; color: #f39c12;" data-value="1">&#9733;</span>
                                        <span style=" font-size: 2.5em; cursor: pointer; color: #f39c12;" data-value="1">&#9733;</span>
                                        <span style=" font-size: 2.5em; cursor: pointer; color: #f39c12;" data-value="1">&#9733;</span>
                                    </div>
                                    <textarea style="font-family: 'Montserrat', sans-serif; width: 100%;
                                            height: 120px;
                                            margin-bottom: 20px;
                                            padding: 15px;
                                            border: none;
                                            background-color: rgba(233,236,241,0.77);
                                            outline: none;
                                            border-radius: 5px;
                                            resize: vertical;
                                            font-size: 0.7rem;
                                            box-sizing: border-box;" disabled placeholder="Enter your review"></textarea>
                                    <button style="font-family: 'Montserrat', sans-serif; padding: 10px 55px;
                                            border: none;
                                            border-radius: 20px;
                                            background-color: #0e77ff;
                                            color: white;
                                            font-size: 0.8rem;
                                            cursor: pointer;">Submit
                                    </button>
                                </div>`

        const ratingHTMLEmoji = `<div style=" text-align: center; padding: 0 10px;">
                                    <div style="display: flex; justify-content: center; margin-bottom: 20px;">😢☹️😐😊😄</div>
                                    <textarea style="font-family: 'Montserrat', sans-serif; width: 100%;
                                            height: 120px;
                                            margin-bottom: 20px;
                                            padding: 15px;
                                            border: none;
                                            background-color: rgba(233,236,241,0.77);
                                            outline: none;
                                            border-radius: 5px;
                                            resize: vertical;
                                            font-size: 0.7rem;
                                            box-sizing: border-box;" disabled placeholder="Enter your review"></textarea>
                                    <button style="font-family: 'Montserrat', sans-serif; padding: 10px 55px;
                                            border: none;
                                            border-radius: 20px;
                                            background-color: #0e77ff;
                                            color: white;
                                            font-size: 0.8rem;
                                            cursor: pointer;">Submit
                                    </button>
                                </div>`

        const quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            }
        });
        let imageHandler = function () {
            let range = quill.getSelection();
            let value = prompt('What is the image URL');
            if (value) {
                quill.insertEmbed(range.index, 'image', value, {
                    width: 300,
                    height: 200
                }, Quill.sources.USER);
            }
        };

        function setNewForm(){
            $("#interval-date").val('');
            $("#email-subject").val('')
            quill.root.innerHTML = '';
            updatePreview()
        }

        function updatePreview() {
            let previewFrame = document.getElementById('preview-frame').contentWindow.document;
            let emailSubject = document.getElementById('email-subject').value;
            let tempContainer = document.createElement('div');

            tempContainer.innerHTML = quill.root.innerHTML;
            let images = tempContainer.querySelectorAll('img');
            images.forEach(function (img) {
                img.style.maxWidth = '100%';
                img.style.height = '150px';
            });
            previewFrame.open();
            const rating_style = $("#rating-style").val();
            if(rating_style == 'stars'){
                previewFrame.write('<h2>' + emailSubject + '</h2>' + tempContainer.innerHTML + ratingHTMLStar);
            }else{
                previewFrame.write('<h2>' + emailSubject + '</h2>' + tempContainer.innerHTML + ratingHTMLEmoji);
            }
            previewFrame.close();
        }

        quill.on('text-change', function (delta, oldDelta, source) {
            if (source === 'user') {
                updatePreview();
            }
        });
        const content = quill.root.innerHTML;

        quill.getModule('toolbar').addHandler('image', selectLocalImage);

        document.getElementById('email-subject').addEventListener('input', updatePreview);

        function switchView(view) {
            let previewFrame = document.getElementById('preview-frame');
            if (view === 'mobile') {
                previewFrame.style.width = '375px';
                previewFrame.style.height = '65vh';
                previewFrame.style.margin = 'auto';
            } else {
                previewFrame.style.width = '100%';
                previewFrame.style.height = '65vh';
            }
        }

        window.onload = updatePreview;

        function submitForm() {
            button.setAttribute("data-kt-indicator", "on");
            const data_send = {};
            const interval_date = $("#interval-date").val();
            if (interval_date < 0 || !interval_date) {
                button.removeAttribute("data-kt-indicator");
                Swal.fire({
                    text: 'Please check interval date',
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                return;
            }
            const email_subject = $("#email-subject").val();
            if (email_subject.trim() == '') {
                button.removeAttribute("data-kt-indicator");
                Swal.fire({
                    text: 'Please check email subject',
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                return;
            }
            const interval_type = $("#interval-type").val();
            data_send.interval_date = interval_date;
            data_send.interval_type = interval_type;
            data_send.rating_style = $("#rating-style").val();
            data_send.email_subject = email_subject;
            data_send.email_body = quill.root.innerHTML;

            $.ajax({
                url: "{{route('review-request.store')}}",
                data: data_send,
                method: 'POST',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                success: function (res) {
                    button.removeAttribute("data-kt-indicator");
                    if($('#list-template').find('.button-template').length < 4){
                        const button_template = `<a href="javascript:;" class="btn btn-success button-template" style="margin-right: 5px;">
                            ${interval_date} ${interval_type}
                        </a>`;
                        $('#list-template').append(button_template);
                        if($('#list-template').find('.button-template').length == 4){
                            $(".btn-add").remove();
                        }
                    }


                    Swal.fire({
                        text: res.data.message,
                        icon: res.status == 200 ? "success" : 'warning',
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });

                },
                error: function (err) {
                    console.log(err)
                    button.removeAttribute("data-kt-indicator");
                    Swal.fire({
                        text: 'Do not save more than 4 samples',
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


</x-default-layout>
