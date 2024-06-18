<x-default-layout>

    @section('title')
        Form
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('manage.form.index') }}
    @endsection

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body py-4">
                            <div class="container">
                                <!--begin::Input group-->
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="ki-duotone ki-profile-circle fs-1"><span class="path1"></span><span class="path2"></span><span
                                                class="path3"></span></i>
                                    </span>
                                    <input type="text" id="username" class="form-control" placeholder="Username" aria-label="Username"
                                           aria-describedby="basic-addon1"/>
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                    <i class="ki-duotone ki-wallet fs-1"><span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span><span class="path4"></span></i>
                                    </span>
                                    <input type="text" class="form-control" id="email" placeholder="Email"
                                           aria-describedby="basic-addon3"/>
                                </div>
                                <!--end::Input group-->
                                <div class="row">
                                    <a href="javascript:;" onclick="saveInformation()" class="btn btn-success hover-scale">Save</a>
                                </div>


                            </div>

                        </div>

                    </div>
                <div class="col-3"></div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            let csrfToken = "{{ csrf_token() }}";
            function saveInformation(id, status, form){
                const username = $('#username').val();
                const email = $('#email').val();
                if(username.trim() == '' || email.trim() == ''){
                    alertError();
                    return;
                }
                const data_send ={
                    'username': username,
                    'email': email
                }
                showLoading()
                $.ajax({
                    url: '/manage/form/save',
                    data: data_send,
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    success: function (res) {
                        if(res.code == 200){
                            $(form).find('.status').first().text(status);
                            alertSuccess('Updated successfully')
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
