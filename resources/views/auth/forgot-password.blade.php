<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ url('css/style.css') }}" />
    <title>Forgot Password</title>
    <style>
        .text-red-500 {
            color: #f56565;
            font-size: 0.875rem;
        }

        .forgot-password {
            display: block;
            margin-top: 10px;
            font-size: 0.875rem;
            color: #1d4ed8;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .back-to-login {
            display: block;
            margin-top: 10px;
            font-size: 0.875rem;
            color: #1d4ed8;
            text-decoration: none;
        }

        .back-to-login:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Password Reset Form -->
                <form method="POST" action="{{ route('password.email') }}" class="sign-in-form">
                    @csrf
                    <img src="{{ url('images/logo_siix.png') }}" alt="Logo" width="180" height="100" />
                    <hr>
                    <h2 class="title">Forgot Password</h2>

                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus autocomplete="username" />
                    </div>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <x-button class="btn solid">
                        {{ __('Send Email') }}
                    </x-button>

                    <!-- Back to Login Button -->
                    <a href="{{ route('login') }}" class="back-to-login">
                        {{ __('Kembali ke Menu Login') }}
                    </a>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Anda Lupa Password?</h3>
                    <p>Silahkan Masukkan Email anda yang sudah terdaftar dan periksa pesan nya lalu reset password anda.</p>
                </div>
                <img src="{{ url('images/forgot.png') }}" class="image" alt="" />
            </div>
        </div>
    </div>

    <script src="{{ url('js/app.js') }}"></script>
</body>
</html>