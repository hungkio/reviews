<x-default-layout>

    @section('title')
        Review Destination
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('settings.review-destination.index') }}
    @endsection

    <div class="card">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <h4 class="mb-3 mt-2">Positive</h4>
            <div class="row">
                <div class="col-md-3 col-6">
                    <select disabled name="card_expiry_month" class="form-select form-select-solid">
                        <option disabled selected value="">4 Star or Above</option>
                    </select>
                </div>
                <div class="col-md-3 col-6">
                    <select onchange="changeSocial()" value="{{$result->social}}" id="social" name="card_expiry_month"
                            class="form-select form-select-solid">
                        <option disabled selected value="null">Select social</option>
                        <option {{$result->social == 'x' ? 'selected' : ''}} value="x">X (Twitter)</option>
                        <option {{$result->social == 'LinkedIn' ? 'selected' : ''}} value="LinkedIn">LinkedIn</option>
                        <option {{$result->social == 'Facebook' ? 'selected' : ''}} value="Facebook">Facebook</option>
                        <option {{$result->social == 'Google' ? 'selected' : ''}} value="Google">Google</option>
                        <option {{$result->social == 'G2' ? 'selected' : ''}} value="G2">G2</option>
                        <option {{$result->social == 'Capterra' ? 'selected' : ''}} value="Capterra">Capterra</option>
                        <option {{$result->social == 'ProductHunt' ? 'selected' : ''}} value="ProductHunt">ProductHunt
                        </option>
                        <option {{$result->social == 'AppSumo' ? 'selected' : ''}} value="AppSumo">AppSumo</option>
                        <option {{$result->social == 'Custom' ? 'selected' : ''}} value="Custom">Custom</option>
                    </select>
                </div>
                <div class="toggle-show-username col-md-3 col-6 {{$result->social == 'Custom' ? '' : 'd-none'}}">
                    <input id="username" class="form-control form-control-solid" placeholder="Enter username"
                           value="{{$result->username}}"/>
                </div>
                <div class="col-md-3 col-6">
                    <input id="url" class="form-control form-control-solid" placeholder="Enter link"
                           value="{{$result->url}}"/>
                </div>
            </div>

            <h4 class="mb-3 mt-2">Critical</h4>
            <div class="row">
                <div class="col-md-3 col-6">
                    <select disabled name="card_expiry_month" class="form-select form-select-solid">
                        <option disabled selected value="">3 Star or Below</option>
                    </select>
                </div>
                <div class="col-md-3 col-6">
                    <select id="send_notice" name="card_expiry_month" class="form-select form-select-solid">
                        <option disabled selected value="">Select send mail or not</option>
                        <option {{$result->send_notice == 1 ? 'selected' : ''}} value="1">Send notification</option>
                        <option {{$result->send_notice == 0 ? 'selected' : ''}} value="0">Don't send notification
                        </option>
                    </select>
                </div>
                <div class="col-md-6 col-6">

                </div>
            </div>

            <div class="row float-end">
                <button onclick="submitForm()" type="button" class="btn btn-primary me-10" id="submit">
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                </button>
            </div>
            </form>
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
        <script>
            var csrfToken = "{{ csrf_token() }}";
            var url = "/settings/review-destination/save";
            var button = document.querySelector("#submit");

            function changeSocial() {
                const social_value = $("#social").val();
                if (social_value == 'Custom') {
                    $(".toggle-show-username").first().removeClass('d-none')
                } else {
                    $(".toggle-show-username").first().addClass('d-none')
                }
            }

            function submitForm() {
                button.setAttribute("data-kt-indicator", "on");
                const data_send = {};
                data_send.social = $("#social").val();
                data_send.username = $("#username").val();
                data_send.url = $("#url").val();
                data_send.send_notice = $("#send_notice").val();

                $.ajax({
                    url: url,
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

    @endpush

</x-default-layout>
