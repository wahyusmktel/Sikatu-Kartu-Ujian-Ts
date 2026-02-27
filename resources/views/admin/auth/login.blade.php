<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | {{ $setting->nama_sekolah ?? 'Sikatu' }}</title>
    <!-- Modern fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --admin-primary: #1a2035;
            --admin-accent: #da251d;
            --sidebar-gradient: linear-gradient(135deg, #1a2035 0%, #2c3e50 100%);
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
            background: var(--sidebar-gradient);
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
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: -1;
        }

        .school-logo {
            width: 120px;
            height: auto;
            border-radius: 15px;
            background: white;
            padding: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }

        .school-info {
            text-align: center;
        }

        .school-info h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .school-info .badge-admin {
            background: var(--admin-accent);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .school-info p {
            font-size: 1.05rem;
            opacity: 0.8;
            max-width: 450px;
            line-height: 1.6;
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
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            margin-bottom: 35px;
        }

        .login-header h2 {
            font-weight: 700;
            color: var(--admin-primary);
            margin-bottom: 8px;
        }

        .login-header p {
            color: #777;
            font-size: 0.95rem;
        }

        .form-group label {
            font-weight: 600;
            color: #555;
            font-size: 0.85rem;
            margin-bottom: 8px;
            display: block;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #bbb;
            transition: all 0.3s;
        }

        .form-control {
            height: 52px;
            padding-left: 50px;
            border-radius: 10px;
            border: 2px solid #f0f0f0;
            background: #fafafa;
            font-weight: 500;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--admin-primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(26, 32, 53, 0.05);
        }

        .form-control:focus + i {
            color: var(--admin-primary);
        }

        .btn-submit {
            height: 52px;
            background: var(--admin-primary);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(26, 32, 53, 0.2);
            margin-top: 15px;
        }

        .btn-submit:hover {
            background: #232a44;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(26, 32, 53, 0.25);
        }

        .login-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 0.85rem;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 25px;
        }

        /* Error Styles */
        .alert-error {
            background: #fff5f5;
            border-left: 4px solid #f56565;
            padding: 12px 15px;
            color: #c53030;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .full-page-wrapper {
                flex-direction: column;
                overflow-y: auto;
            }

            .branding-side {
                flex: none;
                min-height: 40vh;
                padding: 40px 20px;
            }

            .school-logo {
                width: 90px;
                margin-bottom: 20px;
            }

            .school-info h1 {
                font-size: 1.8rem;
            }

            .login-side {
                flex: none;
                min-height: 60vh;
                padding: 40px 20px;
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
                <div class="badge-admin">Admin Portal</div>
                <h1>{{ $setting->nama_sekolah ?? 'SIKATU System' }}</h1>
                <p>Manajemen pusat untuk konfigurasi sistem, data akademik, pengelolaan ujian, dan kontrol akses seluruh platform digital sekolah.</p>
            </div>
        </div>

        <!-- Login Side -->
        <div class="login-side">
            <div class="login-container">
                <div class="login-header">
                    <h2>Selamat Datang Kembali</h2>
                    <p>Silakan masuk ke akun administrator Anda.</p>
                </div>

                @if ($errors->has('loginError'))
                    <div class="alert-error animated fadeIn">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first('loginError') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label>Username</label>
                        <div class="input-wrapper">
                            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required autofocus>
                            <i class="fas fa-user-shield fa-lg"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                            <i class="fas fa-key fa-lg"></i>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme" name="remember">
                            <label class="custom-control-label" for="rememberme" style="font-size: 0.9rem; cursor: pointer;">Ingat Saya</label>
                        </div>
                        <a href="#" style="font-size: 0.85rem; color: #666; text-decoration: none;">Lupa Password?</a>
                    </div>

                    <button type="submit" class="btn-submit">
                        Login Administrator <i class="fas fa-sign-in-alt ml-2"></i>
                    </button>
                </form>

                <div class="login-footer">
                    &copy; {{ date('Y') }} IT Team Dev. Secure Administrative Access.
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <!-- Use Font Awesome for consistency -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
