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
                    <select name="card_expiry_month" class="form-select form-select-solid" data-control="select2">
                        <option disabled selected value="">4 Star or Above</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>
                <div class="col-md-3 col-6">
                    <select name="card_expiry_month" class="form-select form-select-solid" data-control="select2" >
                        <option disabled selected value="">Option</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>
                <div class="col-md-6 col-6">
                    <input class="form-control form-control-solid" placeholder="" value=""/>
                </div>
            </div>

            <h4 class="mb-3 mt-2">Critical</h4>
            <div class="row">
                <div class="col-md-3 col-6">
                    <select name="card_expiry_month" class="form-select form-select-solid" data-control="select2">
                        <option disabled selected value="">3 Star or Below</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>
                <div class="col-md-3 col-6">
                    <select name="card_expiry_month" class="form-select form-select-solid" data-control="select2" >
                        <option disabled selected value="">Option</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>
                <div class="col-md-6 col-6">

                </div>
            </div>

            <div class="row float-end">
                <a href="#" class="btn btn-primary" style="width: 100px">
                    Save
                </a>
            </div>
        </div>
        <!--end::Card body-->
    </div>

    <livewire:permission.permission-modal></livewire:permission.permission-modal>
    @push('scripts')
        <script>



        </script>
    @endpush

</x-default-layout>
