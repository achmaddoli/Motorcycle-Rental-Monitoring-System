@extends('auth.layout')

@section('content')
    <main class="login-form">
        <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="row w-100 justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card border-0 shadow-lg rounded-lg">
                        <div class="card-body p-5 bg-white">

                            <!-- Logo -->
                            <div class="text-center mb-4">
                                <img src="/logo/logomotor.png" alt="Logo" width="80">
                                <h4 class="mt-3 font-weight-bold text-primary">Welcome Back!</h4>
                                <p class="text-muted">Please login to your account</p>
                            </div>

                            <!-- Form -->
                            <form action="{{ route('login.post') }}" method="POST">
                                @csrf

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email_address">Email Address</label>
                                    <input type="email" id="email_address"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <!--<div class="form-group form-check">-->
                                <!--    <input type="checkbox" class="form-check-input" name="remember" id="remember">-->
                                <!--    <label class="form-check-label" for="remember">Remember Me</label>-->
                                <!--</div>-->

                                <!-- Submit -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                                        Login
                                    </button>
                                </div>
                            </form>

                            <!-- Register link -->
                            <!--  <div class="text-center mt-3">-->
                            <!--    <a href="{{ route('register') }}" class="text-primary small">Don't have an account?-->
                            <!--        Register</a>-->
                            <!--</div>-->

                            <!-- Footer -->
                            <div class="text-center mt-4 text-muted small">
                                &copy; {{ date('Y') }} Rental Motor Palembang
                            </div>
                        </div>
                    </div>
                </div>
    </main>
@endsection
