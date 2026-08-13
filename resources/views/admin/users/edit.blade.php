@extends('admin.layout')

@section('title', __('Edit User'))

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            {{ __('Edit User') }}
        </h2>

        <p class="text-muted mb-0">
            {{ __('Update the account information and permissions for :name.', ['name' => $user->name]) }}
        </p>

    </div>


    {{-- User Form --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form
                method="POST"
                action="{{ route('admin.users.update', $user) }}">

                @csrf
                @method('PUT')


                @include('admin.users._form')


                {{-- Form Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="btn btn-light px-4">
                        {{ __('Cancel') }}
                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary px-4">
                        💾 {{ __('Update User') }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection