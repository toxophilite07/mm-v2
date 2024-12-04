@extends('layouts.app')
@section('page-title', 'Account Settings')

@section('styles')
    <style>
        nav, .footer {
            display: none !important;
        }
    </style>
@endsection

@section('contents')
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
            <img src="{{ asset('assets/template/images/404.svg') }}" class="img-fluid mb-2" alt="404">
            <h1 class="font-weight-bold mb-22 mt-2 tx-80 text-muted">503</h1>
            <h4 class="mb-2">Page Under Maintenance and Development</h4>
            <h6 class="text-muted mb-3 text-center">Oops!! The page you were looking for doesn't exist. Please comeback later.</h6>
            <a href="{{ url()->previous() }}" class="btn btn-primary">Return Back</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).find('.sidebar, .navbar, .footer').remove();
            $(document).find('.page-wrapper').addClass('full-page');
            $(document).find('.page-content').addClass('d-flex align-items-center justify-content-center');
        });
    </script>
@endsection
