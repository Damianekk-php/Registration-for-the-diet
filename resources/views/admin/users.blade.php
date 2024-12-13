@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista użytkowników</h1>

        <!-- Formularz filtracji -->
        <form method="GET" action="{{ route('admin.users') }}">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="gender" class="form-label">Płeć</label>
                    <select name="gender" id="gender" class="form-select">
                        <option value="">Wszystkie</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Mężczyzna</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Kobieta</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="country" class="form-label">Kraj</label>
                    <select name="country" id="country" class="form-select">
                        <option value="">Wszystkie</option>
                        <option value="Polska" {{ request('country') == 'Polska' ? 'selected' : '' }}>Polska</option>
                        <option value="Niemcy" {{ request('country') == 'Niemcy' ? 'selected' : '' }}>Niemcy</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="activity_level" class="form-label">Aktywność</label>
                    <select name="activity_level" id="activity_level" class="form-select">
                        <option value="">Wszystkie</option>
                        <option value="low" {{ request('activity_level') == 'low' ? 'selected' : '' }}>Niska</option>
                        <option value="medium" {{ request('activity_level') == 'medium' ? 'selected' : '' }}>Średnia</option>
                        <option value="high" {{ request('activity_level') == 'high' ? 'selected' : '' }}>Wysoka</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary mt-4">Filtruj</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered mt-4">
            <thead>
            <tr>
                <th>ID</th>
                <th>Płeć</th>
                <th>Imię / Nick</th>
                <th>E-mail</th>
                <th>Kraj</th>
                <th>Rola</th>
                <th>Aktywność</th>
                <th>Alergeny</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        @if($user->survey && $user->survey->gender)
                            {{ ucfirst($user->survey->gender) }}
                        @else
                            Brak danych
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->country }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->activity_level }}</td>
                    <td>
                        @if($user->allergens->isNotEmpty())
                            <ul>
                                @foreach($user->allergens as $allergen)
                                    <li>{{ $allergen->allergen }}</li>
                                @endforeach
                            </ul>
                        @else
                            Brak alergenów
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
