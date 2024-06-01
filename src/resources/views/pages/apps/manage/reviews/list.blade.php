<x-default-layout>

    @section('title')
        Reviews
    @endsection

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
                                <select class="form-control form-control-solid" data-control="select2" data-placeholder="Filter">
                                    <option value="" selected disabled>All</option>
                                    <optgroup label="Rating">
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                    </optgroup>
                                    <optgroup label="Status">
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                    </optgroup>
                                    <optgroup label="Source">
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
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
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                        <div data-bs-placement="top" title="Featured">
                                            <i class="fas fa-star" style="color: #fa7023; margin: 10px 0 0 3px"></i>
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div style="display: flex">
                                            <div style="display: flex">
                                                <span>
                                                 <i class="fas fa-star" style="color: gold;"></i>
                                                 <i class="fas fa-star" style="color: gold;"></i>
                                                 <i class="fas fa-star" style="color: gold;"></i>
                                                 <i class="fas fa-star" style="color: gold;"></i>
                                                 <i class="fas fa-star" style="color: gold;"></i>
                                            </span>
                                                <span>
                                                <h3>John Doe</h3>
                                            </span>
                                                <span>
                                                via Email
                                            </span>
                                            </div>
                                            <div>

                                            </div>
                                        </div>
                                        <p>
                                            {{$record->review}}
                                        </p>
                                        <div>
                                            <a href="#" class="btn btn-sm btn-light-primary">Approve</a>
                                            <a href="#" class="btn btn-sm btn-light-danger">Deny</a>
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

            function copyToClipboard(form) {
                const text = $(form).text();
                navigator.clipboard.writeText(text).then(function () {
                    Swal.fire({
                        text: "Copied to clipboard",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }, function (err) {
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                });
            }

            function filter() {
                $('#queue_table').find('.row-item').removeClass('d-none');
                const status = $("#filter_status").val();
                const date = $("#filter_date").val();
                $('#queue_table').find('.row-item').each(function () {
                    const this_date = $(this).find('.date').first().text();
                    const this_status = $(this).find('.status').first().text();
                    if (!status && date != '') {
                        if (this_date == date) {
                            $(this).removeClass('d-none')
                        } else {
                            $(this).addClass('d-none')
                        }
                    }
                    if (status && date == '') {
                        if (this_status == status) {
                            $(this).removeClass('d-none')
                        } else {
                            $(this).addClass('d-none')
                        }
                    }
                    if (status && date != '') {
                        if (this_status == status && this_date == date) {
                            $(this).removeClass('d-none')
                        } else {
                            $(this).addClass('d-none')
                        }
                    }
                    if (!status && date == '') {
                        $(this).removeClass('d-none')
                    }
                });
            }
        </script>

    @endpush

</x-default-layout>
