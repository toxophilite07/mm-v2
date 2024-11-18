<!-- @extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Confirm Your Login</h2>

        @if(session()->has('confirm-login'))
            <div class="alert alert-success">
                {{ session('confirm-login') }}
            </div>
        @endif

        <form action="{{ route('confirm.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="confirmation_code">Enter the confirmation code sent to your email:</label>
                <input type="text" class="form-control" id="confirmation_code" name="confirmation_code" required>
            </div>

            <button type="submit" class="btn btn-primary">Confirm Login</button>
        </form>

        @if($errors->has('confirmation_code'))
            <div class="alert alert-danger mt-3">
                {{ $errors->first('confirmation_code') }}
            </div>
        @endif
    </div>
@endsection -->
