@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista użytkowników</h1>

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
                    <label for="allergen" class="form-label">Alergeny</label>
                    <select name="allergen" id="allergen" class="form-select">
                        <option value="">Wszystkie</option>
                        <option value="mleko_surowe" {{ request('allergen') == 'mleko_surowe' ? 'selected' : '' }}>Mleko surowe</option>
                        <option value="kozie_przetworzone" {{ request('allergen') == 'kozie_przetworzone' ? 'selected' : '' }}>Kozie przetworzone</option>
                        <option value="włoskie_prażone" {{ request('allergen') == 'włoskie_prażone' ? 'selected' : '' }}>Włoskie_prażone</option>
                        <option value="włoskie_surowe" {{ request('allergen') == 'włoskie_surowe' ? 'selected' : '' }}>Włoskie_surowe</option>
                        <option value="wszystkie_rodzaje" {{ request('allergen') == 'wszystkie_rodzaje' ? 'selected' : '' }}>Wszystkie rodzaje</option>
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

        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-6">
                    <h4>Osoby uczulone na alergeny</h4>
                    <canvas id="allUsersWithAllergensChart" style="max-width: 400px; max-height: 400px;"></canvas>
                </div>
                <div class="col-md-6">
                    <h4>Liczba osób uczulonych na konkretne alergeny</h4>
                    <canvas id="allergenBreakdownChart" style="max-width: 400px; max-height: 400px;"></canvas>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const allUsersWithAllergens = {{ $allUsersWithAllergens }};
                const totalUsers = {{ $users->total() }};
                const allergenCounts = @json($allergenCounts);

                const ctx1 = document.getElementById('allUsersWithAllergensChart').getContext('2d');
                new Chart(ctx1, {
                    type: 'pie',
                    data: {
                        labels: ['Uczuleni', 'Nieuczuleni'],
                        datasets: [{
                            data: [allUsersWithAllergens, totalUsers - allUsersWithAllergens],
                            backgroundColor: ['#FF6384', '#36A2EB']
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });

                const ctx2 = document.getElementById('allergenBreakdownChart').getContext('2d');
                new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(allergenCounts),
                        datasets: [{
                            data: Object.values(allergenCounts),
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            });
        </script>


        <a href="{{ route('account.edit') }}" class="btn btn-primary">
            Wróć na strone
        </a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
