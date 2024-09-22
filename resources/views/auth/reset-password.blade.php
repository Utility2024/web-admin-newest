<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ url('css/style.css') }}" />
    <title>Reset Password</title>
    <style>
        .text-red-500 {
            color: #f56565;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Password Reset Form -->
                <form method="POST" action="{{ route('password.update') }}" class="sign-in-form">
                    @csrf
                    <!-- Hidden Token Input -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <img src="{{ url('images/logo_siix.png') }}" alt="Logo" width="180" height="100" />
                    <hr>
                    <h2 class="title">Reset Password</h2>

                    <!-- Display Validation Errors -->
                    <x-validation-errors class="mb-4" />

                    <!-- Email Input -->
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $email)" placeholder="Email" required autofocus autocomplete="username" readonly/>
                    </div>

                    <!-- Password Input -->
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Password" required autocomplete="new-password" />
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password" />
                    </div>

                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    @error('password_confirmation')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror

                    <!-- Reset Password Button -->
                    <x-button class="btn solid">
                        {{ __('Reset Password') }}
                    </x-button>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Reset Password</h3>
                    <p>Silahkan Reset dan ubah password anda untuk keamanan dan kenyamanan dalam bertransaksi.</p>
                </div>
                <img src="{{ url('images/reset.png') }}" class="image" alt="" />
            </div>
        </div>
    </div>

    <script src="{{ url('js/app.js') }}"></script>
</body>
</html>