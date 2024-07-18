@extends('layouts.app')
@section('page-title', 'Profile')

@section('styles')
    <style>
        .card-title {
            font-size: 1.2rem !important;
        }

        #contact_no-error { width: 100%!important }
    </style>
@endsection

@section('contents')
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100 mb-3">
            <div class="col-lg-7">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold mb-0 mt-1">Personal Details</h3>
                    </div>
                    <div class="card-body">
                        <form class="form" id="profile_form" autocomplete="off">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input class="form-control" type="text" id="first_name" name="first_name" placeholder="Enter your first name" value="{{ $user->first_name }}" oninput="handleInputCapitalize(event)">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="middle_name">Middle Name</label>
                                                <input class="form-control" type="text" id="middle_name" name="middle_name" placeholder="Enter your middle name" value="{{ $user->middle_name }}" oninput="handleInputCapitalize(event)">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input class="form-control" type="text" id="last_name" name="last_name" placeholder="Enter your last name" value="{{ $user->last_name }}" oninput="handleInputCapitalize(event)">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-8 col-sm-12">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input class="form-control" type="text" id="address" name="address" placeholder="Enter your current address" value="{{ $user->address }}" oninput="handleInputCapitalize(event)">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label for="birthdate">Birthdate</label>
                                                <div class="input-group date datepicker" id="birthdate_datepicker">
                                                    <input type="text" id="birthdate" name="birthdate" class="form-control" value="{{ date('m/d/Y', strtotime($user->birthdate)) }}">
                                                    <span class="input-group-addon">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-ms-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input class="form-control" type="email" id="email" name="email" placeholder="Enter your current or active email address" value="{{ $user->email }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-ms-12">
                                            <div class="form-group">
                                                <label for="contact_no">Contact No.</label>
                                                <div class="input-group">
                                                    <span class="input-addon px-2 rounded-start-1 border border-end-0 d-flex align-items-center justify-content-center" id="basic-addon1">+63</span>
                                                    <input type="text" id="contact_no" name="contact_no" class="form-control" value="{{ $user->contact_no }}" placeholder="9123456789" oninput="formatPhoneNumber(this)" maxlength="10" pattern="[9]{1}[0-9]{9}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="menstruation_status">Menstruation Status</label>
                                                <select name="menstruation_status" id="menstruation_status">
                                                    <option value="1" {{ $user->menstruation_status == 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ $user->menstruation_status == 0 ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                                <div class="col-12 mt-2">
                                                    <small id="menstruation_help" class="form-text text-muted">
                                                        <li><span class="font-weight-bold">Active</span> - Menstruation is active and not pregnant</li>
                                                        <li><span class="font-weight-bold">Inactive</span> - Menstruation is not active and might be pregnant</li>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col mb-3">
                                            <div class="form-group">
                                                <label for="remarks">Remarks</label>
                                                <textarea class="form-control" id="remarks" name="remarks" rows="5" placeholder="Enter any remarks or notes...">{{ $user->remarks }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="id" value="{{ Auth::user()->id }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit"><i class="fa-regular fa-circle-check"></i> Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold mb-0 mt-1">Account Settings</h3>
                    </div>
                    <div class="card-body">
                        <form class="form" id="password_form">
                            <div class="row">
                                <div class="col-12 col-sm-7 mb-3">
                                    <input type="hidden" id="uid" value="{{ Auth::user()->id }}">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="old_password">Old Password</label>
                                                <input class="form-control" type="password" id="old_password" name="old_password" placeholder="••••••">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="new_password">New Password</label>
                                                <input class="form-control" type="password" id="new_password" name="new_password" placeholder="••••••">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="new_password_confirmation">Confirm New Password</label>
                                                <input class="form-control" type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="••••••">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit"><i class="fa-regular fa-circle-check"></i> Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/template/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/user/menstruation_period_validation.js') }}"></script>

    <script src="{{ asset('assets/js/user/profile.js') }}"></script>
    <script src="{{ asset('assets/js/user/change_password.js') }}"></script>
@endsection