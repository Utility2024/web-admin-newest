<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up Form</title>
    <link rel="stylesheet" href="{{ url('css/login.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <!-- Sign In Form -->
                    <form method="POST" action="{{ route('login') }}" autocomplete="off" class="sign-in-form">
                        @csrf
                        <img src="{{ url('images/logo_siix.png') }}" alt="logo" width="70" height="auto" />
                        <div class="logo">
                            <h4>PORTAL ADMIN. DEPT</h4>
                        </div>

                        <div class="heading">
                            <h2>Welcome Back</h2>
                            <h6>Not registered yet?</h6>
                            <a href="#" class="toggle">Sign up</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <x-input id="nik" type="number" name="nik" class="input-field" :value="old('nik')" placeholder="NIK" required autocomplete="username" />
                            </div>

                            <div class="input-wrap" style="position: relative;">
                                <input id="signin_password" type="password" name="password" class="input-field" placeholder="Password" required />
                                <span toggle="#signin_password"  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></span>
                            </div>

                            <input type="submit" value="Sign In" class="sign-btn" />

                            <p class="text">
                                <a href="{{ route('password.request') }}" class="text">Forgot your password?</a>
                            </p>
                            @error('nik')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('password')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('nik')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('password')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>

                    <!-- Sign Up Form -->
                    <form method="POST" action="{{ route('register') }}" autocomplete="off" class="sign-up-form">
                        @csrf
                        <img src="{{ url('images/logo_siix.png') }}" alt="logo" width="70" height="auto" />

                        <div class="heading">
                            <h2>Get Started</h2>
                            <h6>Already have an account?</h6>
                            <a href="#" class="toggle">Sign in</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <x-input id="nik" type="number" name="nik" class="input-field" :value="old('nik')" placeholder="NIK" required />
                            </div>

                            <div class="input-wrap">
                                <x-input id="name" type="text" name="name" class="input-field" :value="old('name')" placeholder="Name" required />
                            </div>

                            <div class="input-wrap">
                                <x-input id="email" type="email" name="email" class="input-field" :value="old('email')" placeholder="Email" />
                            </div>

                            <div class="input-wrap" style="position: relative;">
                                <input id="signup_password" type="password" name="password" class="input-field" placeholder="Password must be 8 character" required />
                                <span toggle="#signup_password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></span>
                            </div>

                            <div class="input-wrap" style="position: relative;">
                                <input id="password_confirmation" type="password" name="password_confirmation" class="input-field" required placeholder="Confirm Password" />
                                <span toggle="#password_confirmation" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></span>
                            </div>
                            <input type="submit" value="Sign Up" class="sign-btn" />
                        </div>
                    </form>

                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="{{ url('images/login.png') }}" class="image img-1 show" alt="login" />
                        <img src="{{ url('images/register.png') }}" class="image img-2" alt="register" />
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
    <script>
        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', function () {
                const passwordField = document.querySelector(this.getAttribute('toggle'));
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                // Toggle the eye / eye-slash icon
                // this.classList.toggle('fa-eye-slash');
                // this.classList.toggle('fa-eye');
            });
        });
    </script>
</body>
</html>
