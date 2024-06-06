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

        .button-template p{
            margin-bottom: 0!important;
        }

        .btn-add p{
            margin-bottom: 0!important;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


    <body>
    <div class="container">
        <div class="editor mr-2">
            <div class="add-request mb-2">
                <div id="list-template" style="display: flex; float: left">
                    @foreach($templates as $template)
                        <a data-template-id="{{$template->id}}" href="javascript:;" onclick="getTemplateInfor({{$template->id}})" class="btn btn-sm btn-success button-template" style="margin-right: 5px;">
                            <i class="fa fa-envelope"></i>
                            <p>{{$template->interval_date}} {{$template->interval_type}}</p>
                        </a>
                    @endforeach
                </div>
                @if(count($templates) < 4 )
                    <a onclick="setNewForm()" href="javascript:;" class="btn btn-sm btn-primary btn-add">
                        <i class="fa fa-plus"></i>
                        <p>Add</p>
                    </a>
                @endif
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
            <div class="d-none">
                <input type="number" class="d-none" id="template_id" value="0" disabled style="margin-right: 5px;">
            </div>
            <div class="form-group">
                <input onkeydown="updatePreview()" type="text" class="form-control" id="email-subject"
                       name="email-subject" placeholder="Email Subject">
            </div>
            <div id="editor-container"></div>

            <button onclick="submitForm()" data-action="create" type="button" class="btn btn-primary mt-10" id="submit">
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
        let csrfToken = "{{ csrf_token() }}";
        let button = document.querySelector("#submit");
        const ratingHTMLStar = `<div style=" text-align: center; padding: 20px 10px; background-color: {{$background_color}}">
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
            $("#submit").attr('data-action', 'create');
            $("#template_id").val(0);
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
            if($('#list-template').find('.button-template').length == 4){
                return;
            }
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
            const template_id = $("#template_id").val();
            const action = $("#submit").attr('data-action');
            data_send.id = template_id;
            data_send.interval_date = interval_date;
            data_send.interval_type = interval_type;
            data_send.rating_style = $("#rating-style").val();
            data_send.email_subject = email_subject;
            data_send.email_body = quill.root.innerHTML;

            $.ajax({
                url: action == 'create' ? "{{route('review-request.store')}}" : "/review-request/update",
                data: data_send,
                method: 'POST',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                success: function (res) {
                    button.removeAttribute("data-kt-indicator");
                    if(action == 'create'){
                        if($('#list-template').find('.button-template').length < 4){
                            const button_template = `<a href="javascript:;" data-template-id="${res?.template_id}" onclick="getTemplateInfor(${res?.template_id})" class="btn btn-sm btn-success button-template" style="margin-right: 5px;">
                                                    <i class="fa fa-envelope"></i>
                                                    <p>${interval_date} ${interval_type}</p>
                                                </a>`;
                            $('#list-template').append(button_template);
                            if($('#list-template').find('.button-template').length == 4){
                                $(".btn-add").remove();
                            }
                        }
                        $("#template_id").val(res?.template_id);
                        $("#submit").attr('data-action', 'update');
                    }else{
                        $('#list-template').find('.button-template').each(function (){
                            if($(this).attr('data-template-id') == template_id){
                                $(this).find('p').text(`${interval_date} ${interval_type}`);
                            }
                        })
                    }

                    Swal.fire({
                        text: res.message,
                        icon: res.code == 200 ? 'success' : 'warning',
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

        function getTemplateInfor(template_id){
            Swal.fire({
                title: 'Please Wait !',
                html: '',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $("#submit").attr('data-action', 'update');
            $("#template_id").val(template_id);
            $.ajax({
                url: '/review-request/get-template-info',
                data: {'template_id': template_id},
                method: 'POST',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                success: function (res) {
                    swal.close();
                    console.log(res);
                    $("#interval-date").val(res.data.interval_date);
                    $("#interval-type").val(res.data.interval_type);
                    $("#email-subject").val(res.data.email_subject);
                    $("#rating-style").val(res.data.rating_style);
                    quill.root.innerHTML = res.data.email_body;
                    updatePreview()
                },
                error: function (err) {
                    swal.close();
                    console.log(err)
                }
            })
        }
    </script>
    </body>


</x-default-layout>
