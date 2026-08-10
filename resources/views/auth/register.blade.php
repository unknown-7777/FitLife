<x-guest-layout>
    @section('title', 'Register')

    <h4 class="fw-bold text-dark text-center mb-1">Create Account</h4>
    <p class="text-muted text-center small mb-4">Start managing your fitness journey today</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold small text-secondary">Full Name</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0">
                    <i class="bi bi-person"></i>
                </span>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus 
                    autocomplete="name"
                    placeholder="John Doe"
                    class="form-control bg-light border-start-0 @error('name') is-invalid @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 small text-danger" />
        </div>

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
                    autocomplete="username"
                    placeholder="name@example.com"
                    class="form-control bg-light border-start-0 @error('email') is-invalid @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 small text-danger" />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold small text-secondary">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0">
                    <i class="bi bi-lock"></i>
                </span>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="form-control bg-light border-start-0 @error('password') is-invalid @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 small text-danger" />
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold small text-secondary">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0">
                    <i class="bi bi-shield-lock"></i>
                </span>
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="form-control bg-light border-start-0 @error('password_confirmation') is-invalid @enderror"
                />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 small text-danger" />
        </div>

        <button type="submit" class="btn w-100 py-2.5 fw-bold text-white shadow-sm mb-3" style="background-color: #00d4aa; border: none; border-radius: 8px;">
            Create Account <i class="bi bi-arrow-right ms-1"></i>
        </button>
    </form>

    <div class="pt-3 border-top text-center">
        <p class="small text-muted mb-0">
            Already registered? 
            <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #00d4aa;">Log in here</a>
        </p>
    </div>
</x-guest-layout>