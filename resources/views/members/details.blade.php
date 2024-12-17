@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('messages.details_family') }}</h1>

        <p><strong>{{ __('messages.name') }}:</strong> {{ $member->name }}</p>
        <p><strong>{{ __('messages.status') }}:</strong> {{ $member->status }}</p>
        <p><strong>{{ __('messages.email') }}:</strong> {{ $member->email }}</p>

        @if ($user)
            <p><strong>{{ __('messages.country') }}:</strong> {{ $user->country ?? __('messages.no_data') }}</p>
            <p><strong>{{ __('messages.postal_code') }}:</strong> {{ $user->postal_code ?? __('messages.no_data') }}</p>
            <p><strong>{{ __('messages.activity_level') }}:</strong> {{ ucfirst($user->activity_level ?? __('messages.no_data')) }}</p>
            <p><strong>{{ __('messages.age') }}:</strong> {{ $survey->age ?? __('messages.no_data') }}</p>
            <p><strong>{{ __('messages.gender') }}:</strong> {{ $survey->gender ?? __('messages.no_data') }}</p>
            <p><strong>{{ __('messages.height') }}:</strong> {{ $survey->height ?? __('messages.no_data') }}</p>
            <p><strong>{{ __('messages.waist_circumference') }}:</strong> {{ ucfirst($survey->waist_circumference ?? __('messages.no_data')) }}</p>
            <p><strong>{{ __('messages.hip_circumference') }}:</strong> {{ ucfirst($survey->hip_circumference ?? __('messages.no_data')) }}</p>
            <p><strong>{{ __('messages.thigh_circumference') }}:</strong> {{ ucfirst($survey->thigh_circumference ?? __('messages.no_data')) }}</p>
            <p><strong>{{ __('messages.bust_circumference') }}:</strong> {{ ucfirst($survey->bust_circumference ?? __('messages.no_data')) }}</p>
            <p><strong>{{ __('messages.wrist_circumference') }}:</strong> {{ ucfirst($survey->wrist_circumference ?? __('messages.no_data')) }}</p>
            <p><strong>{{ __('messages.bicep_circumference') }}:</strong> {{ ucfirst($survey->bicep_circumference ?? __('messages.no_data')) }}</p>
            <p><strong>{{ __('messages.neck_circumference') }}:</strong> {{ ucfirst($survey->neck_circumference ?? __('messages.no_data')) }}</p>

            <h4>{{ __('messages.allergen') }}</h4>
            @if($allergensd->isNotEmpty())
                <ul>
                    @foreach($allergensd as $allergen)
                        <li>{{ $allergen->allergen }}</li>
                    @endforeach
                </ul>
            @else
                <p>{{ __('messages.no_data') }}</p>
            @endif
        @else
            <p><strong>{{ __('messages.user_data') }}:</strong>{{ __('messages.no_data') }}</p>
        @endif

        <div class="mt-5">
            <h4>{{ __('messages.allergen_stats') }}</h4>
            @if ($allergenStats->isNotEmpty())
                <canvas id="allergenStatsChart" style="max-width: 400px; max-height: 400px;"></canvas>
            @else
                <p>{{ __('messages.no_data') }}</p>
            @endif
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if ($allergenStats->isNotEmpty())
                const allergenLabels = @json($allergenStats->pluck('allergen'));
                const allergenCounts = @json($allergenStats->pluck('count'));

                const ctx = document.getElementById('allergenStatsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: allergenLabels,
                        datasets: [{
                            data: allergenCounts,
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Ilu użytkowników jest uczulonych na poszczególne alergeny'
                            }
                        }
                    }
                });
                @endif
            });
        </script>

        <a href="{{ route('account.edit') }}" class="btn btn-primary">{{ __('messages.go_back') }}</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
