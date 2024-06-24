<x-default-layout>

    @section('title')
        Queue
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.queue.index') }}
    @endsection

    <div class="card">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <div class="row fv-row">
                <div class="col-md-4 col12">
                    <div class="row">
                        <div class="col-6">
                            <select onchange="filter()" id="filter_status" name="card_expiry_month"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Filter">
                                <option selected value="all">All</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Sent">Sent</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Reviewed">Reviewed</option>
                                <option value="Opened">Opened</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Unsubscribed ">Unsubscribed</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <input onchange="filter()" class="form-control form-control-solid" placeholder="Pick a date"
                                   id="filter_date" value=""/>
                        </div>
                    </div>

                </div>
            </div>
            <!--begin::Table-->
            <div class="table-responsive mt-2">
                <table id="queue_table"
                       class="table table-row-bordered align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold"
                       style="width:100%">
                    <thead class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <tr>
                        <th class="text-nowrap">Source</th>
                        <th class="text-nowrap">Customer</th>
                        <th class="text-nowrap">Date</th>
                        <th class="text-start text-nowrap">Status</th>
                        <th class="text-start text-nowrap" style="max-width: 300px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($result as $key => $record)
                        <tr class="row-item">
                            <td data-bs-toggle="tooltip" data-bs-placement="left" title="Click to copy to clipboard"
                                class="payment_id text-nowrap cursor-pointer"
                                onclick="copyToClipboard(this)">{{$record['payment_intent_id']}}</td>
                            <td data-bs-toggle="tooltip" data-bs-placement="left" title="Click to copy to clipboard"
                                class="customer_name text-nowrap cursor-pointer"
                                onclick="copyToClipboard(this)">{{$record['name']}}</td>
                            <td class="date text-nowrap">{{$record['created_at']}}</td>
                            <td class="status text-nowrap">{{$record['status']}}</td>
                            <td class="text-nowrap">
                                <div class="rounded btn-wrapper @if($record['status'] == 'Unsubscribed') d-none @endif">
                                    <a href="javascript:;" onclick="updateStatus({{$record['id']}}, 'Cancel', this.parentElement.parentElement.parentElement, true)" class="btn-cancel btn btn-sm btn-light-primary">Cancel</a>
                                    <a href="javascript:;" onclick="sendMail({{$record['id']}}, 'review', this.parentElement.parentElement.parentElement)" class="btm-send-now btn btn-sm btn-light-success">Send Now</a>
                                    <a href="javascript:;" onclick="updateStatus({{$record['id']}}, 'Unsubscribe', this.parentElement.parentElement.parentElement, true)" class="btn-unsubscribe btn btn-sm btn-light-warning">Unsubscribe</a>
                                </div>
                                <div class="rounded btn-restore  @if($record['status'] != 'Unsubscribed') d-none @endif">
                                    <a href="javascript:;" onclick="updateStatus({{$record['id']}}, 'Scheduled', this.parentElement.parentElement.parentElement, true)" class="btn-resubscribe btn btn-sm btn-light-danger">Resubscribe</a>
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
            let csrfToken = "{{ csrf_token() }}";
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
                    order: [],
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

            function getStatus(status){
                switch (status) {
                    case 'Canceled':
                        return 'CANCELLED';
                    case 'Unsubscribed':
                        return 'UNSUBSCRIBED';
                    case 'Sent':
                        return 'SENT';
                    case 'Scheduled':
                        return 'SCHEDULED';
                    case 'Reviews':
                        return 'REVIEWED';
                    case 'Opened':
                        return 'OPENED';
                    case 'Delivered':
                        return 'DELIVERED';
                    default:
                        return 'ALL'
                }
            }

            function filter() {
                $('#queue_table').find('.row-item').removeClass('d-none');
                let status = $("#filter_status").val();
                status = (status.trim()).toUpperCase();
                const date = $("#filter_date").val();
                $('#queue_table').find('.row-item').each(function () {
                    const this_date = $(this).find('.date').first().text();
                    let this_status = $(this).find('.status').first().text();
                    this_status = getStatus(this_status.trim());
                    if (!status && date != '') {
                        if (this_date == date) {
                            $(this).removeClass('d-none')
                        } else {
                            $(this).addClass('d-none')
                        }
                    }
                    if (status && date == '') {
                        console.log(this_status == status,this_status, status);
                        if (this_status == status || status == "ALL") {
                            $(this).removeClass('d-none')
                        } else {
                            $(this).addClass('d-none')
                        }
                    }
                    if (status && date != '') {
                        console.log(this_status == status , status == 'ALL', this_status, status);
                        if ((this_status == status || status == 'ALL') && this_date == date) {
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

            function sendMail(id, type, form){
                showLoading()
                $.ajax({
                    url: '/send-mail-queue',
                    data: {'type': type , 'id': id},
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    success: function (res) {
                        if(res.code == 500) {
                            swal.close();
                            setTimeout(()=>{
                                Swal.fire({
                                    text: res.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }, 500)
                        }else{
                            alertSuccess('Sent successfully');
                            updateStatus(id, 'Sent', form, false);

                        }
                    },
                    error: function (err) {
                        console.log(err)
                        alertError();
                    }
                })
            }

            function updateStatus(id, status, form, is_alert){
                const status_update = status == 'Cancel' ? 'Canceled' : (status=='Sent' ? 'Sent' : (status=='Scheduled' ? 'Scheduled' : 'Unsubscribed'));
                showLoading()
                $.ajax({
                    url: '/manage/queue/update-status',
                    data: {'id': id, 'status': status_update},
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    success: function (res) {
                        if(res.code == 200){
                            $(form).find('.status').first().text(status_update);
                            if(status_update == 'Unsubscribed'){
                                $(form).find('.btn-restore').first().removeClass('d-none');
                                $(form).find('.btn-wrapper').first().addClass('d-none');
                            }else{
                                $(form).find('.btn-restore').first().addClass('d-none');
                                $(form).find('.btn-wrapper').first().removeClass('d-none');
                            }
                            if(is_alert){
                                alertSuccess('Updated successfully')
                            }
                        }else{
                            alertError();
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        alertError()
                    }
                })
            }
            function alertError(){
                swal.close();
                setTimeout(()=>{
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }, 500)
            }

            function alertSuccess(text){
                swal.close();
                setTimeout(()=>{
                    Swal.fire({
                        text: text,
                        icon: 'success',
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }, 500)
            }

            function showLoading(){
                Swal.fire({
                    title: 'Please Wait !',
                    html: '',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        </script>

    @endpush

</x-default-layout>
