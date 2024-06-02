<x-default-layout>

    @section('title')
        Reviews
    @endsection
        <style>
            .star-gold{
                color: #fa7023!important;
                margin-top: 10px;
                font-size: 1.5rem!important;
            }

            .star-default{
                color: #c9c7c7!important;
                margin-top: 10px;
                font-size: 1.5rem!important;
            }
        </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.reviews.index') }}
    @endsection

    <div class="card">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <div class="row fv-row">
                <div class="col-md-4 col12">
                    <div class="row">
                        <div class="col-4">
                            <select class="form-control form-control-solid" data-control="select2"
                                    data-placeholder="Filter">
                                <option value="" selected disabled>All</option>
                                <optgroup label="Rating">
                                    <option value="0">All</option>
                                    <option value="1">1 star</option>
                                    <option value="2">2 star</option>
                                    <option value="3">3 star</option>
                                    <option value="4">4 star</option>
                                    <option value="5">5 star</option>
                                </optgroup>
                                <optgroup label="Status">
                                    <option value="0">All</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Denied">Denied</option>
                                </optgroup>
                                <optgroup label="Source">
                                    <option value="0">All</option>
                                    <option value="X">X</option>
                                    <option value="LinkedIn">LinkedIn</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Google">Google</option>
                                    <option value="G2">G2</option>
                                    <option value="Capterra">Capterra</option>
                                    <option value="AppSumo">AppSumo</option>
                                    <option value="Email">Email</option>
                                </optgroup>

                            </select>
                        </div>
                        <div class="col-4">
                            <input onchange="filter()" class="form-control form-control-solid" placeholder="Pick a date"
                                   id="filter_date" value=""/>
                        </div>
                        <div class="col-4">
                            <select onchange="filter()" id="filter_status" name="card_expiry_month"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Bulk Actions">
                                <option disabled selected value="">Bulk Actions</option>
                                <option value="Approved">Approved</option>
                                <option value="Deny">Deny</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <!--begin::Table-->
            <div class="table-responsive mt-2">
                <table id="queue_table"
                       class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold"
                       style="width:100%">
                    <thead class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <tr class="d-none">
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($result as $key => $record)
                        <tr class="row-item w-100">
                            <td data-bs-toggle="tooltip" class="row cursor-pointer w-100">
                                <div class="col-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"/>
                                    <div>
                                        <a href="javascript:;" onclick="toggleMarkAsFeatured('{{$record->id}}', this)" data-order={{$record->order ?? 0}}>
                                            <i data-bs-toggle="tooltip" data-bs-placement="top" title="Featured" class="{{ $record->order ? 'star-gold' : 'star-default' }} fas fa-star"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div style="display: flex; justify-content: space-between;">
                                        <div style="display: flex">
                                            <span>
                                                @for ($i = 0; $i < $record->star; $i++)
                                                 <i class="fas fa-star" style="color: gold;"></i>
                                                @endfor
                                            </span>
                                            <span style="margin: 0 10px">
                                                <h3>{{$record->userName}}</h3>
                                            </span>
                                            @if($record->source)
                                                <span>
                                                    via {{$record->source ?? ''}}
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <span>
                                                {{$record->dateTime ?? ''}}
                                            </span>
                                        </div>
                                    </div>
                                    <p>
                                        {{$record->review}}
                                    </p>
                                    <div>
                                        @if(is_null($record->status))
                                        <a onclick="updateStatus(this.parentElement, {{$record->id}}, 1)" href="javascript:;" class="btn-approve btn btn-sm btn-light-primary">Approve</a>
                                        <a onclick="updateStatus(this.parentElement, {{$record->id}}, 0)" href="javascript:;" class="btn-deny btn btn-sm btn-light-danger">Deny</a>
                                        @elseif($record->status == 1)
                                            <p class="text-primary text-approved">Approved</p>
                                        @else
                                            <p class="text-danger text-deny">Denied</p>
                                        @endif
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>

                </table>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
        <script>
            let csrfToken = "{{ csrf_token() }}";
            initDataTable();
            initDatePicker();

            function initDatePicker() {
                $(document).ready(function () {
                    $("#filter_date").daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        minYear: 1901,
                        maxYear: parseInt(moment().format("YYYY"), 12),
                        autoUpdateInput: false,
                        locale: {
                            format: 'DD/MM/YYYY'
                        }
                    });
                    $('#filter_date').on('apply.daterangepicker', function (ev, picker) {
                        var formattedDate = picker.startDate.format('DD/MM/YYYY');
                        $(this).val(formattedDate);
                        filter();
                    });
                    $('#filter_date').val('');
                });
            }

            function initDataTable() {
                $("#queue_table").DataTable({
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom":
                        "<'row mb-2'" +
                        "<'col-sm-6 d-flex align-items-center justify-content-start dt-toolbar'l>" +
                        "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                        ">" +
                        "<'table-responsive'tr>" +
                        "<'row'" +
                        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        ">"
                });
            }

            function updateStatus(form, id, status){
                Swal.fire({
                    title: 'Please Wait !',
                    html: '',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/manage/reviews/update-status',
                    data: {'id': id, 'status': status},
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    success: function (res) {
                        if(res.code == 200){
                            $(form).find(".btn-approve").remove();
                            $(form).find(".btn-deny").remove();
                            alertSuccess(res.message);
                            if(status == 1){
                                $(form).append(`<p class="text-primary text-approved">Approved</p>`)
                            }else{
                                $(form).append(`<p class="text-danger text-deny">Denied</p>`)
                            }
                        }
                        swal.close();
                    },
                    error: function (err) {
                        swal.close();
                        alertError()
                        console.log(err)
                    }
                })
            }

            function toggleMarkAsFeatured(record_id, form){
                const order = $(form).attr('data-order');
                Swal.fire({
                    title: 'Please Wait !',
                    html: '',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/manage/reviews/update-order',
                    data: {'id': record_id},
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    success: function (res) {
                        if(res.code == 200){
                            if(!order || order == 0){
                                $(form).attr('data-order', 1);
                                $(form).find('i').first().removeClass('star-default').addClass('star-gold');
                            }else{
                                $(form).attr('data-order', 0);
                                $(form).find('i').first().removeClass('star-gold').addClass('star-default');
                            }
                            alertSuccess(res.message);
                        }
                        swal.close();
                    },
                    error: function (err) {
                        swal.close();
                        alertError()
                        console.log(err)
                    }
                })
            }

            function alertError(){
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

            function alertSuccess(text){
                Swal.fire({
                    text: text,
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        </script>

    @endpush

</x-default-layout>
