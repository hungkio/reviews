<x-default-layout>

    @section('title')
        Dashboard
    @endsection

        <style>
            /*.rounded h1{*/
            /*    color: white!important;*/
            /*}*/
            /*.rounded h4{*/
            /*    color: white!important;*/
            /*}*/
            /*.rounded span{*/
            /*    color: white!important;*/
            /*}*/
        </style>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body py-10">
            <div class="row pt-2">
                <h3>Hey {{Auth::user()->name}}, Welcome to reviews</h3>
                <span>Here's a quick overview of your account summary</span>
            </div>
            <div class="row pt-4">
                <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 col-12">
                    <div class="rounded border p-10 w-100 bg-success">
                        <h4>This month - April 2024</h4>
                        <div class="row">
                            <div class="col-6">
                                <h1>100</h1>
                                <span>Request sent</span>
                            </div>
                            <div class="col-6">
                                <h1>100</h1>
                                <span>Review received</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 col-12">
                    <div class="rounded border p-10 w-100 bg-warning">
                        <h4>Last month - March 2024</h4>
                        <div class="row">
                            <div class="col-6">
                                <h1>100</h1>
                                <span>Request sent</span>
                            </div>
                            <div class="col-6">
                                <h1>100</h1>
                                <span>Review received</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4 col-12">
                    <div class="rounded border p-10 w-100 bg-danger">
                        <h4>2 months ago - February 2024</h4>
                        <div class="row">
                            <div class="col-6">
                                <h1>100</h1>
                                <span>Request sent</span>
                            </div>
                            <div class="col-6">
                                <h1>100</h1>
                                <span>Review received</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{--    <!--begin::Row-->--}}
    {{--    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">--}}
    {{--            @include('partials/widgets/cards/_widget-20')--}}

    {{--            @include('partials/widgets/cards/_widget-7')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">--}}
    {{--            @include('partials/widgets/cards/_widget-17')--}}

    {{--            @include('partials/widgets/lists/_widget-26')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-xxl-6">--}}
    {{--            @include('partials/widgets/engage/_widget-10')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--    </div>--}}
    {{--    <!--end::Row-->--}}

    {{--    <!--begin::Row-->--}}
    {{--    <div class="row gx-5 gx-xl-10">--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-xxl-6 mb-5 mb-xl-10">--}}
    {{--            @include('partials/widgets/charts/_widget-8')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-xl-6 mb-5 mb-xl-10">--}}
    {{--            @include('partials/widgets/tables/_widget-16')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--    </div>--}}
    {{--    <!--end::Row-->--}}

    {{--    <!--begin::Row-->--}}
    {{--    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-xxl-6">--}}
    {{--            @include('partials/widgets/cards/_widget-18')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-xl-6">--}}
    {{--            @include('partials/widgets/charts/_widget-36')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--    </div>--}}
    {{--    <!--end::Row-->--}}

    {{--    <!--begin::Row-->--}}
    {{--    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-xl-4">--}}
    {{--            @include('partials/widgets/charts/_widget-35')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-xl-8">--}}
    {{--            @include('partials/widgets/tables/_widget-14')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--    </div>--}}
    {{--    <!--end::Row-->--}}

    {{--    <!--begin::Row-->--}}
    {{--    <div class="row gx-5 gx-xl-10">--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-xl-4">--}}
    {{--            @include('partials/widgets/charts/_widget-31')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--        <!--begin::Col-->--}}
    {{--        <div class="col-xl-8">--}}
    {{--            @include('partials/widgets/charts/_widget-24')--}}
    {{--        </div>--}}
    {{--        <!--end::Col-->--}}
    {{--    </div>--}}
    <!--end::Row-->
</x-default-layout>
