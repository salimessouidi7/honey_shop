{{-- Name --}}

<div class="form-group">

    <label class="form-label fw-semibold">
        {{ __('Name') }}
    </label>

    <input
        type="text"
        name="name"
        value="{{ old('name', $user->name ?? '') }}"
        class="form-control @error('name') is-invalid @enderror"
        placeholder="{{ __("Enter user's name") }}"
        required>

    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

</div>

{{-- Email --}}

<div class="form-group">

    <label class="form-label fw-semibold">
        {{ __('Email') }}
    </label>

    <input
        type="email"
        name="email"
        value="{{ old('email', $user->email ?? '') }}"
        class="form-control @error('email') is-invalid @enderror"
        placeholder="user@example.com"
        required>

    @error('email')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

</div>

{{-- Role --}}

<div class="form-group">

    <label class="form-label fw-semibold">
        {{ __('Role') }}
    </label>

    <select
        name="role"
        class="form-select @error('role') is-invalid @enderror"
        required>

        <option
            value="admin"
            @selected(old('role', $user->role ?? '') === 'admin')
            >
            {{ __('Admin — Full access') }}
        </option>

        <option
            value="staff"
            @selected(old('role', $user->role ?? '') === 'staff')
            >
            {{ __('Staff — No delete or user management') }}
        </option>

    </select>

    @error('role')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

</div>

{{-- Password --}}

<div class="form-group">

    <label class="form-label fw-semibold">

        {{ __('Password') }}

        @if (isset($user))
        <span class="text-muted fw-normal">
            ({{ __('optional') }})
        </span>
        @endif

    </label>

    <input
        type="password"
        name="password"
        class="form-control @error('password') is-invalid @enderror"
        placeholder="{{ isset($user) ? __('Leave blank to keep current password') : __('Enter password') }}"
        {{ isset($user) ? '' : 'required' }}>

    @if (isset($user))

    <div class="form-text">
        {{ __("Leave this field blank if you don't want to change the current password.") }}
    </div>

    @endif

    @error('password')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror

</div>

{{-- Confirm Password --}}

<div class="form-group">

    <label class="form-label fw-semibold">
        {{ __('Confirm Password') }}
    </label>

    <input
        type="password"
        name="password_confirmation"
        class="form-control"
        placeholder="{{ __('Confirm password') }}">

</div>