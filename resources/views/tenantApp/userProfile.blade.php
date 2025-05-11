@extends('layouts.userTenantPageLayout')
@section('content')
@section('title', 'Profile')

@php
$colorMapping = [
'purple' => 'primary',
'green' => 'success',
'orange' => 'warning',
'danger' => 'danger',
'azure' => 'info',
];
$cardColor = $colorMapping[$settings->color ?? 'purple'] ?? 'primary';
@endphp

<div class="content">
    <div class="container-fluid">

        @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                showConfirmButton: true,
                timer: 3000,
                background: '#242830',
                color: '#fff',

            });
        </script>
        @endif

        @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: "{{ $errors->first() }}", // Show the first error message
                showConfirmButton: true,
                timer: 3000,
                background: '#242830',
                color: '#fff',
            });
        </script>
        @endif


        <div style="display: flex; align-items: center;">
            <hr class="text-{{ $cardColor }}" style="flex: 0.1; border: none; border-top: 1px solid; margin: 0;">
            <p class="text-{{ $cardColor}}" style="margin: 0 1rem; font-weight: bold;">Profile Information</p>
            <hr class="text-{{ $cardColor }}" style="flex: 1.5; border: none; border-top: 1px solid; margin: 0;">
        </div>

        <div class="row">
            <div class="col">
                <div class="card">

                    <div class="row">

                        <div class="col-12 col-md-6" style="padding: 2rem 3.5rem;">

                            <form action="{{ route('user_profile.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group" style="margin-bottom: 1.5rem; margin-top: 2rem;">
                                    <label class="bmd-label-floating" for="name">Full Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}">
                                </div>
                                <div class=" form-group" style="margin-bottom: 1rem;">
                                    <label class="bmd-label-floating" for="eAddress">Email Address</label>
                                    <input type="text" class="form-control" name="eAddress" id="eAddress" value="{{ old('eAddress', $user->email) }}" readonly style="background-color: transparent;">
                                </div>

                                <div>
                                    <button type=" submit" class="btn btn-{{ $cardColor }}" id="svBtn">Save</button>

                                </div>

                            </form>


                        </div>

                    </div>

                </div>
            </div>
        </div>


        <div style="display: flex; align-items: center;">
            <hr class="text-{{ $cardColor }}" style="flex: 0.1; border: none; border-top: 1px solid; margin: 0;">
            <p class="text-{{ $cardColor}}" style="margin: 0 1rem; font-weight: bold;">Update Password</p>
            <hr class="text-{{ $cardColor }}" style="flex: 1.5; border: none; border-top: 1px solid; margin: 0;">
        </div>

        <div class="row">
            <div class="col">
                <div class="card">

                    <div class="row">

                        <div class="col-12 col-md-6" style="padding: 2rem 3.5rem;">

                            <form action="{{ route('user_profile.updatePassword') }}" method="POST">
                                @csrf

                                <div class="form-group" style="margin-bottom: 1.5rem; margin-top: 2rem;">
                                    <label class="bmd-label-floating" for="cPassword">Current Password</label>
                                    <input type="text" class="form-control" name="cPassword" id="cPassword">
                                </div>
                                <div class="form-group" style="margin-bottom: 1.5rem;">
                                    <label class="bmd-label-floating" for="nPassword">New Password</label>
                                    <input type="password" class="form-control" name="nPassword" id="nPassword">
                                </div>
                                <div class="form-group" style="margin-bottom: 1rem;">
                                    <label class="bmd-label-floating" for="conPassword">Confirm Password</label>
                                    <input type="password" class="form-control" name="nPassword_confirmation" id="conPassword">
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-{{ $cardColor }}" id="svBtn">Save</button>
                                </div>

                            </form>



                        </div>

                    </div>

                </div>
            </div>
        </div>


    </div>
</div>

@endsection