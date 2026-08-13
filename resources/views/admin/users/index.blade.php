@extends('admin.layout')

@section('title', __('Admin Users'))

@section('content')

{{-- Page Header --}}

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>

        <h2 class="fw-bold mb-1">
            {{ __('Users') }}
        </h2>

        <p class="text-muted mb-0">
            {{ __('Manage your administrator and staff accounts.') }}
        </p>

    </div>


    <a
        href="{{ route('admin.users.create') }}"
        class="btn btn-primary">
        + {{ __('Add User') }}
    </a>
    

</div>

{{-- Users Table --}}

<div class="card border-0 shadow-sm">

    
    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="px-4">
                            {{ __('Name') }}
                        </th>

                        <th>
                            {{ __('Email') }}
                        </th>

                        <th>
                            {{ __('Role') }}
                        </th>

                        <th class="text-end px-4">
                            {{ __('Actions') }}
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($users as $user)

                    <tr>


                        {{-- Name --}}
                        <td class="px-4">

                            <div class="d-flex align-items-center">

                                <div class="bg-primary bg-opacity-10 rounded-3 p-2 me-3">

                                    <span>
                                        👤
                                    </span>

                                </div>


                                <div>

                                    <div class="fw-semibold">

                                        {{ $user->name }}

                                        @if ($user->id === auth()->id())

                                        <span class="badge bg-success ms-2">
                                            {{ __('You') }}
                                        </span>

                                        @endif

                                    </div>


                                    <small class="text-muted">
                                        {{ __('User') }} #{{ $user->id }}
                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- Email --}}
                        <td>

                            <span class="text-muted">
                                {{ $user->email }}
                            </span>

                        </td>


                        {{-- Role --}}
                        <td>

                            @if ($user->role === 'admin')

                            <span class="badge bg-primary">
                                {{ __('Admin') }}
                            </span>

                            @else

                            <span class="badge bg-secondary">
                                {{ __('Staff') }}
                            </span>

                            @endif

                        </td>


                        {{-- Actions --}}
                        <td class="text-end px-4">


                            {{-- Edit --}}
                            <a
                                href="{{ route('admin.users.edit', $user) }}"
                                class="btn btn-outline-primary btn-sm">
                                {{ __('Edit') }}
                            </a>


                            {{-- Delete --}}
                            @if ($user->id !== auth()->id())

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal{{ $user->id }}">
                                {{ __('Delete') }}
                            </button>


                            {{-- Delete Confirmation Modal --}}
                            <div
                                class="modal fade"
                                id="deleteUserModal{{ $user->id }}"
                                tabindex="-1"
                                aria-labelledby="deleteUserModalLabel{{ $user->id }}"
                                aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content">


                                        {{-- Modal Header --}}
                                        <div class="modal-header">

                                            <h5
                                                class="modal-title"
                                                id="deleteUserModalLabel{{ $user->id }}">
                                                {{ __('Confirm User Deletion') }}
                                            </h5>


                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>

                                        </div>


                                        {{-- Modal Body --}}
                                        <div class="modal-body text-start">

                                            <p class="mb-2">

                                                {{ __('Are you sure you want to delete') }}
                                                <strong>{{ $user->name }}</strong>?

                                            </p>


                                            <div class="alert alert-danger mb-0">

                                                <strong>⚠️ {{ __('Please note:') }}</strong>

                                                <br>

                                                {{ __('This user account and its access to the admin panel will be permanently removed.') }}

                                                <br>

                                                {{ __('This action cannot be undone.') }}

                                            </div>

                                        </div>


                                        {{-- Modal Footer --}}
                                        <div class="modal-footer">

                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">
                                                {{ __('Cancel') }}
                                            </button>


                                            <form
                                                action="{{ route('admin.users.destroy', $user) }}"
                                                method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="btn btn-danger">
                                                    {{ __('Yes, Delete User') }}
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            @else

                            <span class="text-muted small ms-2">
                                {{ __('Your account') }}
                            </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="4"
                            class="text-center py-5">

                            <div class="text-muted">

                                <div style="font-size: 2.5rem;">
                                    👤
                                </div>


                                <p class="mb-1 fw-semibold">
                                    {{ __('No users yet') }}
                                </p>


                                <small>
                                    {{ __('Create your first administrator or staff account.') }}
                                </small>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection