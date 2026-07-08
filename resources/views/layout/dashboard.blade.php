<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('/backend/assets/images/favicon-32x32.png')}}" type="image/png" />
    <!--plugins-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('/backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet" />
    <link href="{{ asset('/backend/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{ asset('/backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
    <link href="{{ asset('/backend/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- loader-->
    <link href="{{ asset('/backend/assets/css/pace.min.css')}}" rel="stylesheet" />
    <script src="{{ asset('/backend/assets/js/pace.min.js')}}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('/backend/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/backend/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('/backend/assets/css/app.css')}}" rel="stylesheet">
    <link href="{{ asset('/backend/assets/css/icons.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('/backend/assets/css/dark-theme.css')}}" />
    <link rel="stylesheet" href="{{ asset('/backend/assets/css/semi-dark.css')}}" />
    <link rel="stylesheet" href="{{ asset('/backend/assets/css/header-colors.css')}}" />
    <title>Rocker - Bootstrap 5 Admin Dashboard Template</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        @include('backend.body.sidebar')
        <!--end sidebar wrapper -->
        <!--start header -->
        @include('backend.body.header')
        <!--end header -->
        <!--start page wrapper -->
        @yield('dashboards')
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--footer start-->
        @include('backend.body.footer')
        <!--footer end-->


    </div>





    <!--start switcher-->

    <!--end switcher-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('/backend/assets/js/bootstrap.bundle.min.js')}}"></script>
    <!--plugins-->
    <script src="{{ asset('/backend/assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('/backend/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
    <script src="{{ asset('/backend/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
    <script src="{{ asset('/backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('/backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{ asset('/backend/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{ asset('/backend/assets/plugins/chartjs/js/chart.js')}}"></script>
    <script src="{{ asset('/backend/assets/js/index.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="{{ asset('/backend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('/backend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/backend/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
    <!--app JS-->
    <script src="{{ asset('/backend/assets/js/app.js')}}"></script>
    <script>
        new PerfectScrollbar(".app-container")

    </script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>
    <script>
        // init Froala Editor
        // new FroalaEditor('#addDescp');

        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}"
        switch (type) {
            case 'info':
                toastr.info(" {{ Session::get('message') }} ");
                break;
            case 'success':
                toastr.success(" {{ Session::get('message') }} ");
                break;
            case 'warning':
                toastr.warning(" {{ Session::get('message') }} ");
                break;
            case 'error':
                toastr.error(" {{ Session::get('message') }} ");
                break;
        }
        @endif
        $(document).ready(function() {
            $('#viewDataTable').DataTable();
        });
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
        $(document).ready(function() {
            $('#student_photo').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#studentshowImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
            $('#teacher_photo').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#teacherShowImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
            $('#father_photo_teacher').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#fathershowImageTeacher').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
            $('#mother_photo_teacher').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mothershowImageTeacher').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
            $('#father_photo').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#fathershowImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
            $('#mother_photo').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mothershowImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
            $('#guardian_photo').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#guardianshowImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });

    </script>
</body>

</html>
