<x-default-layout>

    @section('title')
        Queue
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('queue-management.queue.index') }}
    @endsection

    <div class="card">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <div class="row fv-row">
                <div class="col-md-4 col12">
                    <div class="row">
                        <div class="col-6">
                            <select onchange="filter()" id="filter_status" name="card_expiry_month" class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Filter">
                                <option disabled selected value="">Filter</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Sent">Sent</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Reviewed">Reviewed</option>
                                <option value="Opened">Opened</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Unsubscribed ">Unsubscribed </option>
                            </select>
                        </div>
                        <div class="col-6">
                            <input onchange="filter()" class="form-control form-control-solid" placeholder="Pick a date" id="filter_date" value=""/>
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
                            <td data-bs-toggle="tooltip" data-bs-placement="left" title="Click to copy to clipboard" class="payment_id text-nowrap cursor-pointer" onclick="copyToClipboard(this)">{{$record['payment_intent_id']}}</td>
                            <td data-bs-toggle="tooltip" data-bs-placement="left" title="Click to copy to clipboard" class="customer_name text-nowrap cursor-pointer" onclick="copyToClipboard(this)">{{$record['name']}}</td>
                            <td class="date text-nowrap">21/02/2024</td>
                            <td class="status text-nowrap">Scheduled</td>
                            <td class="text-nowrap">
                                <div class="rounded">
                                    <a href="#" class="btn btn-sm btn-light-primary">Cancel</a>
                                    <a href="#" class="btn btn-sm btn-light-success">Send Now</a>
                                    <a href="#" class="btn btn-sm btn-light-warning">Unsubscribe</a>
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

    <livewire:permission.permission-modal></livewire:permission.permission-modal>
        @push('scripts')
            <script>
                initDataTable();
                initDatePicker();
                function initDatePicker(){
                    $(document).ready(function() {
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
                        $('#filter_date').on('apply.daterangepicker', function(ev, picker) {
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
                    navigator.clipboard.writeText(text).then(function() {
                        Swal.fire({
                            text: "Copied to clipboard",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }, function(err) {
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
                function filter(){
                    $('#queue_table').find('.row-item').removeClass('d-none');
                    const status = $("#filter_status").val();
                    const date = $("#filter_date").val();
                    $('#queue_table').find('.row-item').each(function() {
                        const this_date = $(this).find('.date').first().text();
                        const this_status = $(this).find('.status').first().text();
                        if(!status && date != ''){
                            if( this_date == date){
                                $(this).removeClass('d-none')
                            }else{
                                $(this).addClass('d-none')
                            }
                        }
                        if(status && date == ''){
                            if(this_status == status){
                                $(this).removeClass('d-none')
                            }else{
                                $(this).addClass('d-none')
                            }
                        }
                        if(status && date != ''){
                            if(this_status == status && this_date == date){
                                $(this).removeClass('d-none')
                            }else{
                                $(this).addClass('d-none')
                            }
                        }
                        if(!status && date == ''){
                            $(this).removeClass('d-none')
                        }
                    });
                }
            </script>

        @endpush

</x-default-layout>
