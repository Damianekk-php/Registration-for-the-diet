<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Pobieranie filtrów z zapytania
        $gender = $request->input('gender');
        $country = $request->input('country');
        $activity_level = $request->input('activity_level');

        // Budowanie zapytania, które uwzględnia filtry
        $query = User::with(['allergens', 'survey']);

        if ($gender) {
            $query->whereHas('survey', function ($q) use ($gender) {
                $q->where('gender', $gender);
            });
        }

        if ($country) {
            $query->where('country', $country);
        }

        if ($activity_level) {
            $query->where('activity_level', $activity_level);
        }

        // Wykonanie zapytania
        $users = $query->get();

        return view('admin.users', compact('users'));
    }
}
