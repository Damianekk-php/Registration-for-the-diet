<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista uzytkownikow</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>Lista uzytkownikow</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Plec</th>
        <th>Imie / Nick</th>
        <th>E-mail</th>
        <th>Kraj</th>
        <th>Rola</th>
        <th>Aktywnosc</th>
        <th>Alergeny</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->survey->gender ?? 'Brak danych' }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->country }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->activity_level }}</td>
            <td>
                @if ($user->allergens->isNotEmpty())
                    <ul>
                        @foreach ($user->allergens as $allergen)
                            <li>{{ $allergen->allergen }}</li>
                        @endforeach
                    </ul>
                @else
                    Brak alergenow
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
