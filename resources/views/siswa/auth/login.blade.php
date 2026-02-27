<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Login</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('assets/img/ts.png') }}" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>

	<script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {
                "families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], 
                urls: ['{{ asset('assets/css/fonts.min.css') }}']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>    
	
	<!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.css') }}">

</head>
<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">
			<h3 class="text-center">Sign In To Student</h3>
			
            <div class="col-md-12">
                <form method="POST" action="{{ route('siswa.login.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label for="username">NIPD</label>
                        <input id="username" type="text" class="form-control" name="username" required autofocus placeholder="Masukkan NIPD">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required placeholder="Masukkan Password (NIPD)">
                    </div>
                    
                    <div class="form-group form-action-d-flex mb-3">
                        <button type="submit" class="btn btn-primary col-md-12 mt-3 mt-sm-0 fw-bold">Login</button>
                    </div>
                </form>

                <div class="login-account text-center mt-3">
                    <span class="msg">Atau masuk dengan</span>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('redirect.google') }}" class="btn btn-danger btn-block">
                        <span class="btn-label">
                            <i class="fab fa-google"></i>
                        </span>
                        Google SSO Email Sekolah
                    </a>
                </div>
                
                <hr>
                <div class="text-center">
                    <p><a class="text-danger" target="_blank" href="#">&copy; 2023 | IT Team Dev</a><br>Jika ada pertanyaan hubungi <br>WA : {{ $setting->no_hp_cs ?? '0821 8590 3635' }}</p>
                </div>
            </div>
		</div>

	</div>
	<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <!-- Bootstrap Notify -->
	<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/atlantis.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Cek jika ada pesan sukses dari session
            @if(session('success'))
                $.notify({
                    // Isi konten notifikasi
                    message: '{{ session('success') }}',
                    title: 'Sukses!',
                    icon: 'fa fa-check'
                }, {
                    type: 'success',
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    time: 1000,
                    delay: 5000,
                });
            @endif

            // Cek jika ada pesan error dari session
            @if(session('error'))
                $.notify({
                    // Isi konten notifikasi
                    message: '{{ session('error') }}',
                    title: 'Error!',
                    icon: 'fa fa-exclamation-triangle'
                }, {
                    type: 'danger',
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    time: 1000,
                    delay: 5000,
                });
            @endif
        });

    </script>

</body>
</html>