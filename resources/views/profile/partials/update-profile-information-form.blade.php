<section class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <header class="mb-4">
            <h5 class="fw-bold text-dark mb-1">
                {{ __('Profile Information') }}
            </h5>
            <p class="text-muted small mb-0">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </header>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <!-- Name Input -->
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">{{ __('Name') }}</label>
                <input 
                    id="name" 
                    name="name" 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name', $user->name) }}" 
                    required 
                    autofocus 
                    autocomplete="name"
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email', $user->email) }}" 
                    required 
                    autocomplete="username"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="small text-muted mb-1">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="btn btn-link p-0 align-baseline text-decoration-underline small">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                {{ __('A new verification link has been sent to your email address.') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Submit Button & Saved Status -->
            <div class="d-flex align-items-center gap-3 mt-4">
                <button type="submit" class="btn btn-dark px-4">{{ __('Save') }}</button>

                @if (session('status') === 'profile-updated')
                    <span class="text-success small fw-semibold">
                        <i class="bi bi-check-circle me-1"></i>{{ __('Saved.') }}
                    </span>
                @endif
            </div>
        </form>
    </div>
</section>