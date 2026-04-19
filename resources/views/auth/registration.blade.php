@extends('auth.layout')

@section('content')
    <main class="login-form">
        <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="row w-100 justify-content-center">
                <div class="col-md-6 col-lg-5"> <!-- Ukuran card disamakan -->
                    <div class="card border-0 shadow-lg rounded-lg">
                        <div class="card-body p-5 bg-white">

                            <!-- Logo -->
                            <div class="text-center mb-4">
                                <img src="/logo/logomotor.png" alt="Logo" width="80">
                                <h4 class="mt-3 font-weight-bold text-primary">Create Account</h4>
                                <p class="text-muted">Please register to create your account</p>
                            </div>

                            <!-- Form -->
                            <form action="{{ route('register.post') }}" method="POST">
                                @csrf

                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" class="form-control" name="name" required
                                        autofocus>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email_address">E-Mail Address</label>
                                    <input type="text" id="email_address" class="form-control" name="email" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <!-- Remember Me -->
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>

                                <!-- Submit -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                                        Register
                                    </button>
                                </div>
                            </form>

                            <!-- Login link -->
                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-primary small">Already have an account? Login</a>
                            </div>

                            <!-- Footer -->
                            <div class="text-center mt-4 text-muted small">
                                &copy; {{ date('Y') }} Rental Motor Palembang
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
