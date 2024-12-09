@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .card-header {
            font-size: 24px;
            text-align: center;
            color: #2a2a2a;
            font-weight: 900;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease;
            padding: 12px 20px;
            font-size: 16px;
            width: 20%;
            border-radius: 10px;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .form-label {
            font-size: 14px;
            font-weight: bold;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .invalid-feedback {
            font-size: 12px;
            color: #e74c3c;
        }

        input {
            max-width: 300px;
        }

        select {
            max-width: 300px;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dane do logowania') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('account.update') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ __('Imię') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', Auth::user()->name) }}" required>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label">{{ __('Adres e-mail') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()->email) }}" required>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">{{ __('Nowe hasło') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">{{ __('Potwierdź hasło') }}</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>

                            <div class="mb-4">
                                <label for="country" class="form-label">{{ __('Kraj') }}</label>
                                <select id="country" class="form-select @error('country') is-invalid @enderror" name="country">
                                    <option value="" disabled {{ old('country', Auth::user()->country) ? '' : 'selected' }}>{{ __('Wybierz kraj') }}</option>
                                    <option value="Polska" {{ old('country', Auth::user()->country) == 'Polska' ? 'selected' : '' }}>{{ __('Polska') }}</option>
                                    <option value="Niemcy" {{ old('country', Auth::user()->country) == 'Niemcy' ? 'selected' : '' }}>{{ __('Niemcy') }}</option>
                                    <option value="Francja" {{ old('country', Auth::user()->country) == 'Francja' ? 'selected' : '' }}>{{ __('Francja') }}</option>
                                    <option value="Wielka Brytania" {{ old('country', Auth::user()->country) == 'Wielka Brytania' ? 'selected' : '' }}>{{ __('Wielka Brytania') }}</option>
                                </select>

                                @error('country')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="postal_code" class="form-label">{{ __('Kod pocztowy') }}</label>
                                <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}">

                                @error('postal_code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-0 text-center">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Zapisz') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
