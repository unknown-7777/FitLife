<section class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <header class="mb-4">
            <h5 class="fw-bold text-dark mb-1">
                {{ __('Update Password') }}
            </h5>
            <p class="text-muted small mb-0">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </header>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

w
            <div class="mb-3">
                <label for="update_password_current_password" class="form-label fw-semibold">
                    {{ __('Current Password') }}
                </label>
                <input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif"
                    autocomplete="current-password"
                >
                @if($errors->updatePassword->has('current_password'))
                    <div class="invalid-feedback">
                        {{ $errors->updatePassword->first('current_password') }}
                    </div>
                @endif
            </div>


            <div class="mb-3">
                <label for="update_password_password" class="form-label fw-semibold">
                    {{ __('New Password') }}
                </label>
                <input
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif"
                    autocomplete="new-password"
                >
                @if($errors->updatePassword->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->updatePassword->first('password') }}
                    </div>
                @endif
            </div>


            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label fw-semibold">
                    {{ __('Confirm Password') }}
                </label>
                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="form-control @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif"
                    autocomplete="new-password"
                >
                @if($errors->updatePassword->has('password_confirmation'))
                    <div class="invalid-feedback">
                        {{ $errors->updatePassword->first('password_confirmation') }}
                    </div>
                @endif
            </div>


            <div class="d-flex align-items-center gap-3 mt-4">
                <button type="submit" class="btn btn-dark px-4">{{ __('Save') }}</button>

                @if (session('status') === 'password-updated')
                    <span class="text-success small fw-semibold">
                        <i class="bi bi-check-circle me-1"></i>{{ __('Saved.') }}
                    </span>
                @endif
            </div>
        </form>
    </div>
</section>
