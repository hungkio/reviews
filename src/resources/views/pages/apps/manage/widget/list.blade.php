<x-default-layout>

    @section('title')
        Widget
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.widget.index') }}
    @endsection

    <div class="card">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="rounded border p-10 w-100">
                        <h4 class="mb-6">Review wall</h4>
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal_preview_review_wall"
                           class="btn btn-link btn-color-success  me-5 mb-2"> Preview</a>
                        <a href="javascript:;" onclick="copyCode('wall')" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="Click to copy code to clipboard"
                           class="btn btn-link btn-color-primary  me-5 mb-2"> Copy code</a>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="rounded border p-10 w-100">
                        <h4 class="mb-6">Badge</h4>
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal_preview_badge"
                           class="btn btn-link btn-color-success  me-5 mb-2"> Preview</a>
                        <a href="javascript:;" onclick="copyCode('badge')" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="Click to copy code to clipboard"
                           class="btn btn-link btn-color-primary  me-5 mb-2"> Copy code</a>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="rounded border p-10 w-100">
                        <h4 class="mb-6">Notifications</h4>
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal_preview_toast"
                           class="btn btn-link btn-color-success  me-5 mb-2"> Preview</a>
                        <a href="javascript:;" onclick="copyCode('notification')" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="Click to copy code to clipboard"
                           class="btn btn-link btn-color-primary  me-5 mb-2"> Copy code</a>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="rounded border p-10 w-100">
                        <h4 class="mb-6">Carousel</h4>
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#modal_preview_carousel"
                           class="btn btn-link btn-color-success  me-5 mb-2"> Preview</a>
                        <a href="javascript:;" onclick="copyCode('carousel')" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="Click to copy code to clipboard"
                           class="btn btn-link btn-color-primary  me-5 mb-2"> Copy code</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Card body-->
        <!--end::Modal preview-->
        <div class="modal fade" tabindex="-1" id="modal_preview_review_wall">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview review wall</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                             aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <iframe style="width: 100%; overflow-y: scroll; height: 65vh"
                                src="{{url('/preview/wall')}}"></iframe>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="modal_preview_badge">
            <div class="modal-dialog modal-dialog-scrollable modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview badge</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                             aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <iframe style="width: 100%; overflow-y: scroll; height: 15vh"
                                src="{{url('/preview/badge')}}"></iframe>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="modal_preview_toast">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview Notifications</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                             aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <iframe style="width: 100%; overflow-y: scroll; height: 65vh"
                                src="{{url('/preview/toast')}}"></iframe>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="modal_preview_carousel">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview carousel</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                             aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <iframe style="width: 100%; overflow-y: scroll; height: 65vh"
                                src="{{url('/preview/carousel')}}"></iframe>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal preview-->

    </div>

    @push('scripts')
            <script>
                const badge_widget_html = `<div id="import_badge" style="width: 250px; height: 50px;"></div>`;
                const badge_widget_script = `<script src="https://reviews.stage.n-framescorp.com/assets/plugins/custom/widget/badge.js"><\/script>`;

                const review_wall_widget_html = `<div class="container" id="container"></div>`;
                const review_wall_widget_script = `<script src="https://reviews.stage.n-framescorp.com/assets/plugins/custom/widget/review-wall.js"><\/script>`;

                const notification_widget_html = `<div id="toast"><button class="close-btn" onclick="closeToast()">&times;</button></div>`;
                const notification_widget_script = `<script src="https://reviews.stage.n-framescorp.com/assets/plugins/custom/widget/notification.js"><\/script>`;

                const carousel_widget_html = `<div class="carousel-container">
        <button class="carousel-button prev" onclick="moveCarousel(-1)">
            <i class="action-btn fa fa-solid fa-arrow-left"></i>
        </button>
        <div class="carousel">
            <div class="carousel-items">
            </div>
        </div>
        <button class="carousel-button next" onclick="moveCarousel(1)">
            <i class="action-btn fa fa-solid fa-arrow-right"></i>
        </button>
    </div>`;
                const carousel_widget_script = `<script src="https://reviews.stage.n-framescorp.com/assets/plugins/custom/widget/carousel.js"><\/script>`;

                function copyCode(type) {
                    let text = '';
                    if (type == 'wall') {
                        text = review_wall_widget_html + review_wall_widget_script;
                    }
                    if (type == 'badge') {
                        text = badge_widget_html + badge_widget_script;
                    }
                    if (type == 'notification') {
                        text = notification_widget_html + notification_widget_script;
                    }
                    if (type == 'carousel') {
                        text = carousel_widget_html + carousel_widget_script;
                    }
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
            </script>


        @endpush

</x-default-layout>
