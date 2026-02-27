<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa Login | {{ $setting->nama_sekolah ?? 'Sikatu' }}</title>
    <!-- Modern fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-red: #da251d;
            --primary-red-hover: #b71c1c;
            --accent-red: #ff5252;
            --sidebar-bg: linear-gradient(135deg, #da251d 0%, #a01c1c 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Outfit', sans-serif;
            overflow: hidden;
        }

        .full-page-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Branding Side */
        .branding-side {
            flex: 1.2;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 60px;
            position: relative;
            z-index: 1;
        }

        .branding-side::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: -1;
        }

        .school-logo {
            width: 140px;
            height: auto;
            border-radius: 20px;
            background: white;
            padding: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }

        .school-info {
            text-align: center;
        }

        .school-info h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: -1px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .school-info p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 400px;
            line-height: 1.6;
        }

        .branding-footer {
            position: absolute;
            bottom: 40px;
            font-size: 0.9rem;
            opacity: 0.7;
        }

        /* Login Side */
        .login-side {
            flex: 1;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
        }

        .login-container {
            width: 100%;
            max-width: 380px;
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h2 {
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 0.95rem;
        }

        /* Form Styling */
        .form-group label {
            font-weight: 600;
            color: #444;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 25px;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            transition: color 0.3s;
        }

        .form-control {
            height: 55px;
            padding-left: 50px;
            border-radius: 12px;
            border: 2px solid #f0f0f0;
            background: #fdfdfd;
            font-weight: 500;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-red);
            background: white;
            box-shadow: 0 0 0 4px rgba(218, 37, 29, 0.1);
        }

        .form-control:focus + i {
            color: var(--primary-red);
        }

        .btn-submit {
            height: 55px;
            background: var(--primary-red);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(218, 37, 29, 0.3);
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: var(--primary-red-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(218, 37, 29, 0.4);
        }

        .divider {
            margin: 30px 0;
            position: relative;
            text-align: center;
        }

        .divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #eee;
            z-index: 0;
        }

        .divider span {
            position: relative;
            background: white;
            padding: 0 15px;
            color: #999;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .btn-google {
            height: 55px;
            background: white;
            border: 2px solid #f0f0f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #444;
            font-weight: 600;
            text-decoration: none !important;
            transition: all 0.3s;
            gap: 12px;
        }

        .btn-google:hover {
            background: #f9f9f9;
            border-color: #e0e0e0;
            transform: translateY(-2px);
        }

        .help-section {
            margin-top: 30px;
            font-size: 0.9rem;
            color: #888;
            text-align: center;
        }

        .help-section a {
            color: var(--primary-red);
            font-weight: 600;
            text-decoration: none;
        }

        .help-section a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .full-page-wrapper {
                flex-direction: column;
                overflow-y: auto;
            }

            .branding-side {
                flex: none;
                padding: 40px 20px;
                min-height: 40vh;
            }

            .school-logo {
                width: 100px;
            }

            .school-info h1 {
                font-size: 2rem;
            }

            .branding-footer {
                display: none;
            }

            .login-side {
                padding: 40px 20px;
                flex: none;
                min-height: 60vh;
            }
        }
    </style>
</head>
<body>

    <div class="full-page-wrapper">
        <!-- Branding Side -->
        <div class="branding-side">
            <div class="logo-box">
                @if($setting && $setting->logo_sekolah)
                    <img src="{{ asset('storage/' . $setting->logo_sekolah) }}" alt="Logo" class="school-logo">
                @else
                    <img src="{{ asset('assets/img/ts.png') }}" alt="Logo" class="school-logo">
                @endif
            </div>
            <div class="school-info">
                <h1>{{ $setting->nama_sekolah ?? 'SIKATU System' }}</h1>
                <p>Selamat datang di Portal Digital Sekolah. Platform terintegrasi untuk manajemen ujian, data akademik, dan informasi terpadu.</p>
            </div>
            <div class="branding-footer">
                &copy; {{ date('Y') }} IT Team Dev. All rights reserved.
            </div>
        </div>

        <!-- Login Side -->
        <div class="login-side">
            <div class="login-container">
                <div class="login-header">
                    <h2>Masuk Akun Siswa</h2>
                    <p>Silakan gunakan kredensial (NIPD) Anda untuk melanjutkan akses platform.</p>
                </div>

                <form method="POST" action="{{ route('siswa.login.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nomor Induk Siswa (NIPD)</label>
                        <div class="input-wrapper">
                            <input type="text" name="username" class="form-control" placeholder="Masukkan NIPD" required autofocus>
                            <i class="fas fa-user-circle fa-lg"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Kata Sandi</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                            <i class="fas fa-lock fa-lg"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        Login ke Dashboard <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </form>

                <!-- <div class="divider">
                    <span>Atau gunakan sSO</span>
                </div>

                <a href="{{ route('redirect.google') }}" class="btn-google">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="22" alt="Google">
                    Login via Email Sekolah
                </a> -->

                <div class="help-section">
                    @php
                        $csWA = $setting->no_hp_cs ?? '082185903635';
                        $cleanCS = preg_replace('/[^0-9]/', '', $csWA);
                        if (strpos($cleanCS, '0') === 0) {
                            $cleanCS = '62' . substr($cleanCS, 1);
                        }
                    @endphp
                    Punya kendala akses? <a href="https://wa.me/{{ $cleanCS }}?text=Halo%20Admin%2C%20saya%20mengalami%20kendala%20saat%20login%20ke%20Sikatu.">Hubungi Admin Disini</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            @if(session('success'))
                $.notify({
                    message: "{{ session('success') }}",
                    title: 'Berhasil!',
                    icon: 'fas fa-check-circle'
                }, {
                    type: 'success',
                    placement: { from: "top", align: "right" },
                    time: 500,
                    delay: 4000,
                });
            @endif

            @if(session('error'))
                $.notify({
                    message: "{{ session('error') }}",
                    title: 'Login Gagal!',
                    icon: 'fas fa-exclamation-circle'
                }, {
                    type: 'danger',
                    placement: { from: "top", align: "right" },
                    time: 500,
                    delay: 4000,
                });
            @endif
        });
    </script>
</body>
</html>