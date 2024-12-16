@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Szczegóły członka rodziny</h1>

        <p><strong>Imię:</strong> {{ $member->name }}</p>
        <p><strong>Status:</strong> {{ $member->status }}</p>
        <p><strong>Email:</strong> {{ $member->email }}</p>

        @if ($user)
            <p><strong>Kraj:</strong> {{ $user->country ?? 'Brak danych' }}</p>
            <p><strong>Kod pocztowy:</strong> {{ $user->postal_code ?? 'Brak danych' }}</p>
            <p><strong>Poziom aktywności:</strong> {{ ucfirst($user->activity_level ?? 'Brak danych') }}</p>
            <p><strong>Wiek:</strong> {{ $survey->age ?? 'Brak danych' }}</p>
            <p><strong>Płeć:</strong> {{ $survey->gender ?? 'Brak danych' }}</p>
            <p><strong>Wzrost:</strong> {{ $survey->height ?? 'Brak danych' }}</p>
            <p><strong>Obwód tali:</strong> {{ ucfirst($survey->waist_circumference ?? 'Brak danych') }}</p>
            <p><strong>Obwód biodra:</strong> {{ ucfirst($survey->hip_circumference ?? 'Brak danych') }}</p>
            <p><strong>Obwód uda:</strong> {{ ucfirst($survey->thigh_circumference ?? 'Brak danych') }}</p>
            <p><strong>Obwód biustu:</strong> {{ ucfirst($survey->bust_circumference ?? 'Brak danych') }}</p>
            <p><strong>Obwód nadgarstka:</strong> {{ ucfirst($survey->wrist_circumference ?? 'Brak danych') }}</p>
            <p><strong>Obwód bicepsu:</strong> {{ ucfirst($survey->bicep_circumference ?? 'Brak danych') }}</p>
            <p><strong>Obwód szyi:</strong> {{ ucfirst($survey->neck_circumference ?? 'Brak danych') }}</p>
        @else
            <p><strong>Dane użytkownika:</strong> Brak dodatkowych informacji.</p>
        @endif

        <a href="{{ route('account.edit') }}" class="btn btn-primary">Wróć do listy</a>
    </div>
@endsection
