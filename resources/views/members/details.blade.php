@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Szczegóły członka rodziny</h1>

        <p><strong>Imię:</strong> {{ $member->name }}</p>
        <p><strong>Status:</strong> {{ $member->status }}</p>
        <p><strong>Email:</strong> {{ $member->email }}</p>

        <a href="{{ route('account.edit') }}" class="btn btn-primary">Wróć do listy</a>
    </div>
@endsection
