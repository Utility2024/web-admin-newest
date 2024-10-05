<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ url('css/login.css') }}" />
    <title>Forgot Password</title>
</head>
<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <!-- Password Reset Form -->
                    <form method="POST" action="{{ route('password.email') }}" class="sign-in-form" autocomplete="off">
                        @csrf
                        <div class="logo">
                            <h4>PORTAL ADMIN. DEPT</h4>
                        </div>

                        <div class="heading">
                            <h2>Forgot Your Password?</h2>
                            <p>Insert Your Email</p>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <i class="#"></i>
                                <x-input id="email" class="input-field" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus autocomplete="username" />
                            </div>

                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror

                            <input type="submit" value="Send Email" class="sign-btn" />

                            <!-- Back to Login Button -->
                            <p class="text">
                                <a href="{{ route('login') }}" class="back-to-login">Sign in Again?</a>
                            </p>
                        </div>
                    </form>
                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="{{ url('images/forgot.png') }}" class="image img-1 show" alt="Forgot Password" />
                    </div>

                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>PT. SIIX-EMS INDONESIA</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Javascript file -->
    <script src="{{ url('js/login.js') }}"></script>
</body>
</html>
