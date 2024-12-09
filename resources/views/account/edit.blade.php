@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .card-header {
            font-size: 24px;
            text-align: left;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            width: 100%;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-control, .form-select {
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
        }

        .form-section {
            margin-top: 40px;
        }

        .form-section-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #34495e;
        }

        .radio-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .two-columns {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (max-width: 768px) {
            .two-columns {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Dane do logowania') }}</div>
            <form method="POST" action="{{ route('account.update') }}">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Imię / Nick') }}</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Adres e-mail') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Nowe hasło') }}</label>
                    <input id="password" type="password" class="form-control" name="password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">{{ __('Potwierdź hasło') }}</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                </div>

                <div class="form-group">
                    <label for="country" class="form-label">{{ __('Kraj') }}</label>
                    <select id="country" class="form-select" name="country">
                        <option value="Polska" {{ old('country', Auth::user()->country) == 'Polska' ? 'selected' : '' }}>Polska</option>
                        <option value="Niemcy" {{ old('country', Auth::user()->country) == 'Niemcy' ? 'selected' : '' }}>Niemcy</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="postal_code" class="form-label">{{ __('Kod pocztowy') }}</label>
                    <input id="postal_code" type="text" class="form-control" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}">
                </div>

                <button type="submit" class="btn btn-success">{{ __('Zapisz') }}</button>
            </form>
        </div>

        <div class="card">
            <div class="card-header">{{ __('Ankieta') }}</div>
            <form method="POST" action="{{ route('account.survey.store') }}">
                @csrf
                <h3 class="text-center">Ankieta</h3>

                <div class="mb-4">
                    <label for="gender" class="form-label">Płeć</label><br>
                    <input type="radio" id="gender_male" name="gender" value="Mężczyzna" onchange="togglePregnancyFields()"> Mężczyzna
                    <input type="radio" id="gender_female" name="gender" value="Kobieta" onchange="togglePregnancyFields()"> Kobieta
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3">Dane obowiązkowe</h4>
                        <div class="mb-3">
                            <label for="height" class="form-label">Wzrost (cm)</label>
                            <input type="number" id="height" name="height" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Waga (kg)</label>
                            <input type="number" id="weight" name="weight" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Wiek</label>
                            <input type="number" id="age" name="age" class="form-control">
                        </div>
                        <div id="pregnancy_fields" style="display: none;">
                            <div class="mb-3">
                                <label>Czy jesteś w ciąży lub karmisz piersią?</label><br>
                                <input type="radio" id="is_pregnant_yes" name="is_pregnant" value="1" onchange="togglePregnancyDetails()"> Jestem w ciąży
                                <input type="radio" id="is_pregnant_no" name="is_pregnant" value="0" onchange="togglePregnancyDetails()"> Nie
                            </div>
                            <div id="pregnancy_details" style="display: none;">
                                <div class="mb-3">
                                    <label for="pregnancy_week" class="form-label">Tydzień ciąży</label>
                                    <input type="number" id="pregnancy_week" name="pregnancy_week" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="pre_pregnancy_weight" class="form-label">Waga sprzed ciąży (kg)</label>
                                    <input type="number" id="pre_pregnancy_weight" name="pre_pregnancy_weight" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="delivery_date" class="form-label">Data porodu</label>
                                    <input type="date" id="delivery_date" name="delivery_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4 class="mb-3">Dane opcjonalne</h4>
                        <div class="mb-3">
                            <label for="waist_circumference" class="form-label">Obwód pasa (cm)</label>
                            <input type="number" id="waist_circumference" name="waist_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="hip_circumference" class="form-label">Obwód bioder (cm)</label>
                            <input type="number" id="hip_circumference" name="hip_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="bust_circumference" class="form-label">Obwód biustu (cm)</label>
                            <input type="number" id="bust_circumference" name="bust_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="neck_circumference" class="form-label">Obwód szyi (cm)</label>
                            <input type="number" id="neck_circumference" name="neck_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="wrist_circumference" class="form-label">Obwód nadgarstka (cm)</label>
                            <input type="number" id="wrist_circumference" name="wrist_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="bicep_circumference" class="form-label">Obwód bicepsa (cm)</label>
                            <input type="number" id="bicep_circumference" name="bicep_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="thigh_circumference" class="form-label">Obwód uda (cm)</label>
                            <input type="number" id="thigh_circumference" name="thigh_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="calf_circumference" class="form-label">Obwód łydki (cm)</label>
                            <input type="number" id="calf_circumference" name="calf_circumference" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success">Zapisz ankietę</button>
                </div>
            </form>

            <script>
                function togglePregnancyFields() {
                    const gender = document.querySelector('input[name="gender"]:checked')?.value;
                    document.getElementById('pregnancy_fields').style.display = (gender === 'Kobieta') ? 'block' : 'none';
                    togglePregnancyDetails();
                }

                function togglePregnancyDetails() {
                    const isPregnant = document.querySelector('input[name="is_pregnant"]:checked')?.value;
                    document.getElementById('pregnancy_details').style.display = (isPregnant === '1') ? 'block' : 'none';
                }
            </script>


        </div>
    </div>
@endsection
