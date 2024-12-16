@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Zaproszenie dla {{ $familyMember->name }}</h1>

        <p>Skopiuj poniższy link i udostępnij go osobie, którą zapraszasz:</p>

        <div class="alert alert-info">
            <strong>Link aktywacyjny:</strong>
            <input type="text" class="form-control" value="{{ $activationLink }}" readonly onclick="this.select()">
        </div>

        <p>Po otwarciu linku przez zaproszoną osobę, jej status zostanie zmieniony na "Aktywny".</p>

        <a href="{{ route('account.edit') }}" class="btn btn-primary">Wróć do panelu</a>
    </div>
@endsection
