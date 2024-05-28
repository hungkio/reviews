<x-default-layout>

    @section('title')
    Review Destination
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('settings.review-destination.index') }}
    @endsection

    <?php
    $check_frequency = $result->frequency ?? null;
    ?>

    <!--begin::Card body-->
    <div class="container">
        <div class="card">
            <div class="card-body py-4">
                <h4 class="mb-3 mt-2">Review Request Frequency</h4>
                <div class="row">
                    <div class="col-md-3 col-6">
                        <select value="{{$check_frequency}}" id="frequency" name="card_expiry_month" class="form-select">
                            <option disabled selected value="null">Select frequency</option>
                            <option {{$check_frequency == '0' ? 'selected' : ''}} value="0">Every payment</option>
                            <option {{$check_frequency == '1' ? 'selected' : ''}} value="1">First payment only</option>
                            <option {{$check_frequency == '2' ? 'selected' : ''}} value="2">Skip first payment, send from second onwards</option>
                            <option {{$check_frequency == '3' ? 'selected' : ''}} value="3">Skip first two payments, send from third onwards</option>
                            <option {{$check_frequency == '4' ? 'selected' : ''}} value="4">Alternative payments</option>
                            <option {{$check_frequency == '5' ? 'selected' : ''}} value="5">Skip the customer when a review has been submitted before</option>
                        </select>
                    </div>
                </div>
                <h5 class="mt-2">
                    Since taking the course I've unlocked my earning potential and I'm now richer than my wildest dreams. Thank you so much for the awesome course.
                </h5>

                <div class="row float-end">
                    <button onclick="submitForm()" type="button" class="btn btn-primary me-10" id="submit">
                        <span class="indicator-label">
                            Save
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                </form>
            </div>
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
    <script>
        var csrfToken = "{{ csrf_token() }}";
        var button = document.querySelector("#submit");

        function submitForm() {
            button.setAttribute("data-kt-indicator", "on");
            const frequency = $("#frequency").val();
            console.log(frequency)

            $.ajax({
                url: "{{route('settings.frequency.store')}}",
                data: { frequency: frequency },
                method: 'POST',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                success: function(res) {
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
                error: function(err) {
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