@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <form method="POST" action="{{ route('register') }}" name="role">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        @csrf

                        <div class="form-group row">
                            <div class="col">
                                <label for="first_name" class="">First Name</label>
                                <input id="first_name" type="text"
                                    class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                    value="{{ old('first_name') }}" autocomplete="first_name" autofocus>

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="last_name" class="">Last Name</label>
                                <input id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                    value="{{ old('last_name') }}" autocomplete="last_name" autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="username" class="">Username</label>
                                <input id="username" type="username"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" autocomplete="username">

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="email" class="">{{ __('E-Mail Address')
                                    }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label for="password" class="">{{ __('Password')
                                    }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="password-confirm" class="">{{
                                    __('Confirm
                                    Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="0">Admin</option>
                                    <option value="1">Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class="btn btn-primary w-50 my-3 text-white">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
