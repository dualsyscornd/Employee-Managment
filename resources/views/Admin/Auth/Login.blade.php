<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Task And Attendence Management System For Dualsysco R&D.">
    <meta name="author" content="Dualsysco">
    <meta name="keywords" content="employees,employee,employee management,employee management system,">

    <title>Dualsysco -employee management || Admin Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{url('public/assets/vendors/core/core.css')}}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{url('public/assets/fonts/feather-font/css/iconfont.css')}}">
    <link rel="stylesheet" href="{{url('public/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{url('public/assets/css/demo1/style.css')}}">
    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{url('public/assets/images/favicon.png')}}" />
</head>

<body>
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">

                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-4 pe-md-0">
                                    <div class="auth-side-wrapper">

                                    </div>
                                </div>
                                <div class="col-md-8 ps-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="#" class="noble-ui-logo d-block mb-2">Dualsysco <span>Admin
                                                Login</span></a>
                                        <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                                        <form id="login_form">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="userEmail" class="form-label">Email address</label>
                                                <input type="email" class="form-control" id="userEmail"
                                                    placeholder="Email" name="admin_email">
                                            </div>
                                            <div class="mb-3">
                                                <label for="userPassword" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="userPassword"
                                                    autocomplete="current-password" name="admin_password"
                                                    placeholder="Password">
                                            </div>
                                            <div id="error">

                                            </div>
                                            <div>
                                                <button type="button"
                                                    class=" login-btn btn btn-primary me-2 mb-2 mb-md-0 text-white"
                                                    onclick="Login()">
                                                    <span class="spinner-border d-none  spinner-border-sm" role="status"
                                                        aria-hidden="true"></span>
                                                    Login</button>
                                            </div>
                                            <a href="javascriptscript:void(0)" class="d-block mt-3 text-muted">Not a
                                                user? Sign
                                                up</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- core:js -->
    <script src="{{url('public/assets/vendors/core/core.js')}}"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="{{url('public/assets/vendors/feather-icons/feather.min.js')}}"></script>
    <script src="{{url('public/assets/js/template.js')}}"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <!-- End custom js for this page -->

    <script>
    function Login() {
        $.ajax({
            type: "GET",
            url: "{{url('AdminLogin')}}",
            data: $("#login_form").serialize(),
            beforeSend: function() {
                $(".login-btn").prop('disabled',true);
                $(".spinner-border").removeClass('d-none')
            },
            success: function(data) {
                $(".login-btn").prop('disabled',false);
                $(".spinner-border").addClass('d-none')
                if (data['success'] == true) {
                    $("#error").addClass('alert alert-success').html('Login successfull please wait...');
                    window.location = "{{route('Dashboard')}}";
                } else {
                    $("#error").addClass('alert alert-danger').html('Invalid credentials please try again.')
                }
            }
        })
    }
    </script>

</body>

</html>
