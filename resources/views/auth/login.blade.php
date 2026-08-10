<x-guest-layout>
    @section('title', 'Login')

    <h4 class="fw-bold text-dark text-center mb-1">Welcome Back</h4>
    <p class="text-muted text-center small mb-4">Please enter your details to log in</p>


    <x-auth-session-status class="mb-3 text-center text-success small" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf


        <div class="mb-3">
            <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0">
                    <i class="bi bi-envelope"></i>
                </span>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="name@example.com"
                    class="form-control bg-light border-start-0 @error('email') is-invalid @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 small text-danger" />
        </div>


        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label fw-semibold small text-secondary mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-decoration-none small" style="color: #00d4aa;" href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0">
                    <i class="bi bi-lock"></i>
                </span>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="form-control bg-light border-start-0 @error('password') is-invalid @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 small text-danger" />
        </div>


        <div class="mb-4 form-check">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
            <label for="remember_me" class="form-check-label text-secondary small select-none">Remember me</label>
        </div>


        <button type="submit" class="btn w-100 py-2.5 fw-bold text-white shadow-sm" style="background-color: #00d4aa; border: none; border-radius: 8px;">
            Log In <i class="bi bi-arrow-right ms-1"></i>
        </button>
    </form>


    @if (Route::has('register'))
        <div class="mt-4 pt-3 border-top text-center">
            <p class="small text-muted mb-0">
                Don't have an account? 
                <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #00d4aa;">Register here</a>
            </p>
        </div>
    @endif
</x-guest-layout>