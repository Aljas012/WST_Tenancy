@extends('layouts.tenantPageLayout')
@section('content')
@section('title', 'Settings')

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
            <p class="text-{{ $cardColor}}" style="margin: 0 1rem; font-weight: bold;">UI Customization</p>
            <hr class="text-{{ $cardColor }}" style="flex: 1.5; border: none; border-top: 1px solid; margin: 0;">
        </div>

        <div class="row">
            <div class="col">
                <div class="card">

                    <div class="row">


                        <div class="col-12 col-md-4">
                            <div style="padding: 1rem;">
                                <h5 style="color: #eaeaff;">Color</h5>

                                <div class="fixed-plugin">
                                    <a href="javascript:void(0)" class="switch-trigger active-color">

                                        <div class="badge-colors ml-auto mr-auto" style="background-color: #202940; display: flex; flex-direction: column; align-items: flex-start; padding: 10px; gap:.6rem">
                                            <span style="display: flex; align-items: center;">
                                                <span class="badge filter badge-purple @if($settings && $settings->color == 'purple') active @endif" data-color="purple"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Purple</p>
                                            </span>
                                            <span style="display: flex; align-items: center;">
                                                <span class="badge filter badge-azure @if($settings && $settings->color == 'azure') active @endif" data-color="azure"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Azure</p>
                                            </span>
                                            <span style="display: flex; align-items: center;">
                                                <span class="badge filter badge-green @if($settings && $settings->color == 'green') active @endif" data-color="green"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Green</p>
                                            </span>
                                            <span style="display: flex; align-items: center;">
                                                <span class="badge filter badge-warning @if($settings && $settings->color == 'orange') active @endif" data-color="orange"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Orange</p>
                                            </span>
                                            <span style="display: flex; align-items: center;">
                                                <span class="badge filter badge-danger @if($settings && $settings->color == 'danger') active @endif" data-color="danger"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Danger</p>
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a>
                                </div>


                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div style="padding: 1rem;">
                                <h5 style="color: #eaeaff;">Font</h5>

                                <div class="fixed-plugin font">
                                    <a href="javascript:void(0)" class="switch-trigger active-font" style="cursor: pointer;">

                                        <div class="badge-colors ml-auto mr-auto" style="background-color: #202940; display: flex; flex-direction: column; align-items: flex-start; padding: 10px; gap: .6rem; cursor: pointer;">
                                            <span style="display: flex; align-items: center; cursor: pointer;">
                                                <span class="badge font filter  @if($settings && $settings->font == 'poppins') active @endif" data-font="poppins"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Poppins</p>
                                            </span>
                                            <span style="display: flex; align-items: center; cursor: pointer;">
                                                <span class="badge font filter  @if($settings && $settings->font == 'roboto') active @endif" data-font="roboto"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Roboto</p>
                                            </span>
                                            <span style="display: flex; align-items: center; cursor: pointer;">
                                                <span class="badge font filter  @if($settings && $settings->font == 'lora') active @endif" data-font="lora"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Lora</p>
                                            </span>
                                            <span style="display: flex; align-items: center; cursor: pointer;">
                                                <span class="badge font filter @if($settings && $settings->font == 'opensans') active @endif" data-font="opensans"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Open Sans</p>
                                            </span>
                                            <span style="display: flex; align-items: center; cursor: pointer;">
                                                <span class="badge font filter @if($settings && $settings->font == 'tahoma') active @endif" data-font="tahoma"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Tahoma</p>
                                            </span>
                                        </div>

                                        <style>
                                            .fixed-plugin.font .badge.font.active {
                                                background-color: #333333 !important;


                                            }
                                        </style>

                                        <div class="clearfix"></div>

                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div style="padding: 1rem;">
                                <h5 style="color: #eaeaff;">Layout</h5>

                                <div class="fixed-plugin layout">
                                    <a href="javascript:void(0)" class="switch-trigger active-layout">

                                        <div class="badge-colors ml-auto mr-auto" style="background-color: #202940; display: flex; flex-direction: column; align-items: flex-start; padding: 10px; gap:.6rem">
                                            <!-- Left Sidebar Option -->
                                            <span style="display: flex; align-items: center;">
                                                <span class="badge layout filter @if($settings && $settings->layout == '0') active @endif" data-layout="left-sidebar"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Left Sidebar</p>
                                            </span>

                                            <!-- Right Sidebar Option -->
                                            <span style="display: flex; align-items: center;">
                                                <span class="badge layout filter @if($settings && $settings->layout == '1') active @endif" data-layout="right-sidebar"></span>
                                                <p style="margin: 0; margin-left: 10px; color: white;">Right Sidebar</p>
                                            </span>
                                        </div>

                                        <style>
                                            .fixed-plugin.layout .badge.layout.active {
                                                background-color: #333333 !important;


                                            }
                                        </style>

                                        <div class="clearfix"></div>
                                    </a>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; margin-top: 1.5rem;">
            <hr class="text-{{ $cardColor }}" style="flex: 0.1; border: none; border-top: 1px solid; margin: 0;">
            <p class="text-{{ $cardColor}}" style="margin: 0 1rem; font-weight: bold;">Service Customization</p>
            <hr class="text-{{ $cardColor }}" style="flex: 1.5; border: none; border-top: 1px solid; margin: 0;">
        </div>

        <div class="row">
            <div class="col">
                <div class="card">

                    <div class="row">

                        <div class="col-12 col-md-4">
                            <div style="padding: 1rem;">
                                <h5 style="color: #eaeaff;">Mechanic Incentive</h5>

                                <div style="margin-top: 1.5rem">
                                    <form action="{{ route('settings.updateIncentive') }}" method="POST">

                                        @csrf
                                        <div class="form-group">
                                            <label for="pIncentives" class="bmd-label-floating">Update Incentive Percentage</label>
                                            <input type="text" class="form-control" id="pIncentives" name="incentive_percentage" min="0" max="100" value="{{ isset($settings->incentive_percentage) ? rtrim(rtrim(number_format($settings->incentive_percentage, 2, '.', ''), '0'), '.') . '%' : '' }}">
                                        </div>

                                        <div style="display: flex; justify-content: end;">
                                            <button type="submit" class="btn btn-{{ $cardColor }}" id="prcntBtn">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div style="padding: 1rem;">
                                <h5 style="color: #eaeaff;">Subscription</h5>

                                <div style="margin-top: 1.5rem">
                                    <form action="{{ route('settings.upgrade') }}" method="POST">

                                        @csrf
                                        <div class="form-group">
                                            <label for="subsReq" class="bmd-label-floating">Current Subscription</label>
                                            <input type="text" class="form-control" id="subsReq" value="{{ $subscription }}" name="subscription_request" readonly style="background-color: transparent;">
                                        </div>

                                        <div style="display: flex; justify-content: end;">
                                            <button type="submit" class="btn btn-{{ $cardColor }}" id="UpgrdBtn">Request</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; margin-top: 1.5rem;">
            <hr class="text-{{ $cardColor }}" style="flex: 0.1; border: none; border-top: 1px solid; margin: 0;">
            <p class="text-{{ $cardColor}}" style="margin: 0 1rem; font-weight: bold;">Customer Support</p>
            <hr class="text-{{ $cardColor }}" style="flex: 1.5; border: none; border-top: 1px solid; margin: 0;">
        </div>

        <div class="row">
            <div class="col">
                <div class="card">

                    <div class="row">

                        <div class="col-12 col-md-6">
                            <div style="padding: 1rem;">
                                <h5 style="color: #eaeaff;">Report a Bug</h5>

                                <div style="margin-top: 1.5rem">
                                    <form action="{{ route('settings.bug') }}" method="POST">

                                        @csrf
                                        <div class="form-group">
                                            <label for="rprtBg">Provide a detailed information</label>
                                            <textarea class="form-control" name="rprtBg" id="rprtBg" rows="4"></textarea>
                                        </div>

                                        <div style="display: flex; justify-content: end;">
                                            <button type="submit" class="btn btn-{{ $cardColor }}" id="rprtBgBtn">Report</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div style="padding: 1rem;">
                                <h5 style="color: #eaeaff;">Developer's Contacts</h5>

                                <div style="margin-top: 1rem; padding-top: 1.5rem; display: flex; justify-content: center; gap: 6rem; flex-wrap: wrap; text-align: center;">
                                    <div>
                                        <h5 style="color: #eaeaff; font-size: 14px;">Email</h5>
                                        <p style="color: #eaeaff;">apsone069@gmail.com</p>
                                    </div>

                                    <div>
                                        <h5 style="color: #eaeaff; font-size: 14px;">Phone Number</h5>
                                        <p style="color: #eaeaff;">+63 936 512 9269</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>


    </div>

    <script>
        document.getElementById('pIncentives').addEventListener('input', function() {
            let value = this.value;

            value = value.replace(/[^0-9]/g, '');

            if (value !== '' && (parseInt(value) < 1 || parseInt(value) > 100)) {

                if (parseInt(value) < 1) {
                    value = '1';
                } else if (parseInt(value) > 100) {
                    value = '100';
                }
            }

            // Set the filtered value back to the input field
            this.value = value;
        });
    </script>

</div>

@endsection