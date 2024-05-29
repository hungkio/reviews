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
                        <a href="javascript:;" onclick="showPreview('review_wall')" data-bs-toggle="modal" data-bs-target="#modal_preview_review_wall" class="btn btn-link btn-color-success btn-active-color-warning me-5 mb-2"> Preview</a>
                        <a href="javascript:;"  onclick="copyCode('review_wall')" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to copy code to clipboard" class="btn btn-link btn-color-primary btn-active-color-warning me-5 mb-2"> Copy code</a>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="rounded border p-10 w-100">
                        <h4 class="mb-6">Badge</h4>
                        <a href="javascript:;" onclick="showPreview('review_wall')" data-bs-toggle="modal" data-bs-target="#modal_preview_badge" class="btn btn-link btn-color-success btn-active-color-warning me-5 mb-2"> Preview</a>
                        <a href="javascript:;"  onclick="copyCode('review_wall')" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to copy code to clipboard" class="btn btn-link btn-color-primary btn-active-color-warning me-5 mb-2"> Copy code</a>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="rounded border p-10 w-100">
                        <h4 class="mb-6">Notifications</h4>
                        <a href="javascript:;" onclick="showPreview('review_wall')" data-bs-toggle="modal" data-bs-target="#modal_preview_toast" class="btn btn-link btn-color-success btn-active-color-warning me-5 mb-2"> Preview</a>
                        <a href="javascript:;"  onclick="copyCode('review_wall')" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to copy code to clipboard" class="btn btn-link btn-color-primary btn-active-color-warning me-5 mb-2"> Copy code</a>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="rounded border p-10 w-100">
                        <h4 class="mb-6">Carousel</h4>
                        <a href="javascript:;" onclick="showPreview('review_wall')" data-bs-toggle="modal" data-bs-target="#modal_preview_carousel" class="btn btn-link btn-color-success btn-active-color-warning me-5 mb-2"> Preview</a>
                        <a href="javascript:;"  onclick="copyCode('review_wall')" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to copy code to clipboard" class="btn btn-link btn-color-primary btn-active-color-warning me-5 mb-2"> Copy code</a>
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
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <iframe style="width: 100%; overflow-y: scroll; height: 65vh" src="{{url('/preview/wall')}}"></iframe>
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
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <iframe style="width: 100%; overflow-y: scroll; height: 15vh" src="{{url('/preview/badge')}}"></iframe>
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
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <iframe style="width: 100%; overflow-y: scroll; height: 65vh" src="{{url('/preview/toast')}}"></iframe>
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
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <iframe style="width: 100%; overflow-y: scroll; height: 65vh" src="{{url('/preview/carousel')}}"></iframe>
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
            function showPreview(type){

            }

            function copyCode(type){
                const text = type;
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
