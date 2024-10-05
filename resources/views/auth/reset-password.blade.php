<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ url('css/login.css') }}" />
</head>
<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <!-- Password Reset Form -->
                    <form method="POST" action="{{ route('password.update') }}" class="sign-in-form" autocomplete="off">
                        @csrf
                        <!-- Hidden Token Input -->
                        <input type="hidden" name="token" value="{{ $token }}">

                        <h4>PORTAL ADMIN. DEPT</h4>

                        <div class="heading">
                            <h2>Reset Password</h2>
                        </div>

                        <div class="actual-form">
                            <!-- Email Input -->
                            <div class="input-wrap">
                                <!-- <i class="fas fa-envelope"></i> -->
                                <x-input id="email" class="input-field" type="email" name="email" :value="old('email', $email)" placeholder="Email" required autofocus autocomplete="username" readonly />
                            </div>

                            <!-- New Password Input -->
                            <div class="input-wrap">
                                <!-- <i class="fas fa-lock"></i> -->
                                <x-input id="password" class="input-field" type="password" name="password" placeholder="New Password" required autocomplete="new-password" />
                            </div>

                            <!-- Confirm New Password Input -->
                            <div class="input-wrap">
                                <!-- <i class="fas fa-lock"></i> -->
                                <x-input id="password_confirmation" class="input-field" type="password" name="password_confirmation" placeholder="Confirm New Password" required autocomplete="new-password" />
                            </div>

                            <!-- Display Errors -->
                            @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('password')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @error('password_confirmation')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror

                            <!-- Submit Button -->
                            <input type="submit" value="Reset Password" class="sign-btn" />
                        </div>
                    </form>
                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="{{ url('images/reset.png') }}" class="image img-1 show" alt="Reset Password" />
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
